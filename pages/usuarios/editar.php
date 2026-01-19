<?php
$pageTitle = "Editar Usuario";

require_once __DIR__ . '/../../includes/config.php';

// ==============================
// 1️⃣ Obtener ID
// ==============================
$id_persona = $_GET['id'] ?? null;
if (!$id_persona) {
    header("Location: listado.php");
    exit;
}

// ==============================
// 2️⃣ Cargar datos del usuario
// ==============================
$sql = "
    SELECT
        id_persona,
        nombre,
        apellido1,
        apellido2,
        cedula,
        id_estado
    FROM tbl_persona
    WHERE id_persona = :id
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_persona]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: listado.php");
    exit;
}

// ==============================
// 3️⃣ Guardar cambios
// ==============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Datos generales
    $nombre      = $_POST['nombre'];
    $apellido1   = $_POST['apellido1'];
    $apellido2   = $_POST['apellido2'];
    $cedula      = $_POST['cedula'];
    $estado      = $_POST['estado'];

    // 🔁 Actualizar datos generales
    $stmt = $pdo->prepare("CALL sp_editar_persona(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $id_persona,
        $nombre,
        $apellido1,
        $apellido2,
        0,                // grado académico (placeholder)
        $cedula,
        '1990-01-01',     // fecha nacimiento (placeholder)
        ''                // imagen (placeholder)
    ]);
    $stmt->closeCursor();

    // 🔐 Cambiar contraseña (opcional)
    if (!empty($_POST['password'])) {
        if ($_POST['password'] === $_POST['password_confirm']) {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("CALL sp_actualizar_contrasena(?, ?)");
            $stmt->execute([$id_persona, $hash]);
            $stmt->closeCursor();
        }
    }

    // 🔁 Estado (activo / inactivo)
    $stmt = $pdo->prepare("
        UPDATE tbl_persona 
        SET id_estado = ?, actualizado_en = CURRENT_TIMESTAMP
        WHERE id_persona = ?
    ");
    $stmt->execute([$estado, $id_persona]);

    header("Location: listado.php");
    exit;
}

ob_start();
?>

<div class="container-fluid page-inner">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Editar Usuario</h1>

        <a href="/pages/usuarios/listado.php" class="btn btn-secondary">
            ← Volver al listado
        </a>
    </div>

    <div class="card shadow-sm p-4">

        <form method="POST">

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                           value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Primer apellido</label>
                    <input type="text" name="apellido1" class="form-control"
                           value="<?= htmlspecialchars($usuario['apellido1']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Segundo apellido</label>
                    <input type="text" name="apellido2" class="form-control"
                           value="<?= htmlspecialchars($usuario['apellido2']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cédula</label>
                    <input type="text" name="cedula" class="form-control"
                           value="<?= htmlspecialchars($usuario['cedula']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="1" <?= $usuario['id_estado']==1?'selected':'' ?>>Activo</option>
                        <option value="0" <?= $usuario['id_estado']==0?'selected':'' ?>>Inactivo</option>
                    </select>
                </div>

                <hr class="mt-4">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmar contraseña</label>
                    <input type="password" name="password_confirm" class="form-control">
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Guardar cambios</button>
                <a href="/pages/usuarios/listado.php" class="btn btn-light">Cancelar</a>
            </div>

        </form>

    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
