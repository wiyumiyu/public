<?php
$pageTitle = "Editar Usuario";
require_once __DIR__ . '/../../includes/config.php';

/* =====================================================
   1️⃣ OBTENER ID
   ===================================================== */
$id_persona = $_GET['id'] ?? null;
if (!$id_persona) {
    header("Location: listado.php");
    exit;
}

/* =====================================================
   1️⃣.1 ELIMINAR TELÉFONO (MISMO ARCHIVO)
   ===================================================== */
if (isset($_GET['del_tel'])) {
    $stmt = $pdo->prepare("CALL sp_eliminar_persona_telefono(?)");
    $stmt->execute([(int)$_GET['del_tel']]);
    $stmt->closeCursor();

    header("Location: editar.php?id=".$id_persona);
    exit;
}

/* =====================================================
   2️⃣ CARGAR USUARIO (SP)
   ===================================================== */
$stmt = $pdo->prepare("CALL sp_obtener_persona(?)");
$stmt->execute([$id_persona]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

if (!$usuario) {
    header("Location: listado.php");
    exit;
}

/* =====================================================
   2️⃣.1 CARGAR CORREOS (SP)
   ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_correos_persona(?)");
$stmt->execute([$id_persona]);
$correos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
   2️⃣.2 CARGAR TELÉFONOS (SP)
   ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_telefonos_persona(?)");
$stmt->execute([$id_persona]);
$telefonos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* =====================================================
   2️⃣.3 CARGAR TIPOS DE TELÉFONO (SP)
   ===================================================== */
$stmt = $pdo->prepare("CALL sp_listar_tipos_telefono()");
$stmt->execute();
$tiposTelefono = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

/* HTML reutilizable */
$opcionesTelefonoHTML = '';
foreach ($tiposTelefono as $tt) {
    $opcionesTelefonoHTML .= '<option value="'.$tt['id'].'">'
        . htmlspecialchars($tt['nombre']) .
    '</option>';
}

/* =====================================================
   3️⃣ GUARDAR CAMBIOS
   ===================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* 🔹 Datos generales */
    $stmt = $pdo->prepare("CALL sp_editar_persona(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $id_persona,
        $_POST['nombre'],
        $_POST['apellido1'],
        $_POST['apellido2'],
        0,
        $_POST['cedula'],
        '1990-01-01',
        ''
    ]);
    $stmt->closeCursor();

    /* 🔹 Estado */
    $stmt = $pdo->prepare("CALL sp_actualizar_estado_persona(?, ?)");
    $stmt->execute([$id_persona, $_POST['estado']]);
    $stmt->closeCursor();

    /* 🔹 Contraseña */
    if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_confirm']) {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("CALL sp_actualizar_contrasena(?, ?)");
        $stmt->execute([$id_persona, $hash]);
        $stmt->closeCursor();
    }

    /* 🔹 Correos nuevos */
    if (!empty($_POST['nuevo_correo'])) {
        foreach ($_POST['nuevo_correo'] as $i => $correo) {
            $stmt = $pdo->prepare("CALL sp_agregar_persona_correo(?, ?, ?)");
            $stmt->execute([$id_persona, $correo, $_POST['correo_desc'][$i]]);
            $stmt->closeCursor();
        }
    }

    /* 🔹 Teléfonos nuevos */
    if (!empty($_POST['nuevo_telefono'])) {
        foreach ($_POST['nuevo_telefono'] as $i => $telefono) {
            $stmt = $pdo->prepare("CALL sp_agregar_persona_telefono(?, ?, ?)");
            $stmt->execute([
                $id_persona,
                $_POST['telefono_tipo'][$i],
                $telefono
            ]);
            $stmt->closeCursor();
        }
    }

    /* 🔹 Teléfonos existentes (hover-edit) */
    if (!empty($_POST['telefono_existente'])) {
        foreach ($_POST['telefono_existente'] as $id_tel => $valor) {
            $stmt = $pdo->prepare("CALL sp_editar_persona_telefono(?, ?, ?)");
            $stmt->execute([
                $id_tel,
                $_POST['telefono_tipo_existente'][$id_tel],
                $valor
            ]);
            $stmt->closeCursor();
        }
    }

    header("Location: listado.php");
    exit;
}

ob_start();
?>

<div class="container-fluid page-inner">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold">Editar Usuario</h1>
    <a href="/pages/usuarios/listado.php" class="btn btn-secondary">← Volver</a>
</div>

<div class="card shadow-sm p-4">
<form method="POST">

<!-- DATOS PERSONALES -->
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label fw-semibold">Nombre</label>
        <input name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Primer apellido</label>
        <input name="apellido1" class="form-control" value="<?= htmlspecialchars($usuario['apellido1']) ?>" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Segundo apellido</label>
        <input name="apellido2" class="form-control" value="<?= htmlspecialchars($usuario['apellido2']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Cédula</label>
        <input name="cedula" class="form-control" value="<?= htmlspecialchars($usuario['cedula']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Estado</label>
        <select name="estado" class="form-select">
            <option value="1" <?= $usuario['id_estado']==1?'selected':'' ?>>Activo</option>
            <option value="0" <?= $usuario['id_estado']==0?'selected':'' ?>>Inactivo</option>
        </select>
    </div>
</div>

<hr class="mt-4">

<!-- CONTRASEÑA -->
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nueva contraseña</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Confirmar contraseña</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>
</div>

<hr class="mt-4">

<!-- CORREOS -->
<h5 class="fw-bold">Correos electrónicos</h5>
<div id="correos-container">
<?php foreach ($correos as $c): ?>
<div class="row g-2 mb-2">
    <div class="col-md-6"><input class="form-control" value="<?= htmlspecialchars($c['correo']) ?>" disabled></div>
    <div class="col-md-4"><input class="form-control" value="<?= htmlspecialchars($c['descripcion']) ?>" disabled></div>
    <div class="col-md-2">
        <a href="correo_eliminar.php?id=<?= $c['id'] ?>&persona=<?= $id_persona ?>"
           class="btn btn-outline-danger w-100">✖</a>
    </div>
</div>
<?php endforeach; ?>
</div>

<button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarCorreo()">Agregar correo</button>

<hr class="mt-4">

<!-- TELÉFONOS -->
<h5 class="fw-bold">Teléfonos</h5>
<div id="telefonos-container">
<?php foreach ($telefonos as $t): ?>
<div class="row g-2 mb-2 telefono-row">
    <div class="col-md-5">
        <input name="telefono_existente[<?= $t['id'] ?>]"
               class="form-control telefono-input"
               value="<?= htmlspecialchars($t['telefono']) ?>" readonly>
    </div>
    <div class="col-md-5">
        <select name="telefono_tipo_existente[<?= $t['id'] ?>]"
                class="form-select telefono-select d-none">
            <?php foreach ($tiposTelefono as $tt): ?>
            <option value="<?= $tt['id'] ?>" <?= $tt['id']==$t['id_telefono_tipo']?'selected':'' ?>>
                <?= htmlspecialchars($tt['nombre']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        <input class="form-control telefono-tipo-text" value="<?= htmlspecialchars($t['tipo']) ?>" readonly>
    </div>
    <div class="col-md-2">
        <a href="editar.php?id=<?= $id_persona ?>&del_tel=<?= $t['id'] ?>"
           class="btn btn-outline-danger w-100"
           onclick="return confirm('¿Eliminar este teléfono?')">✖</a>
    </div>
</div>
<?php endforeach; ?>
</div>

<button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="agregarTelefono()">Agregar teléfono</button>

<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary px-4">Guardar cambios</button>
    <a href="/pages/usuarios/listado.php" class="btn btn-light">Cancelar</a>
</div>

</form>
</div>
</div>

<script>
const opcionesTelefono = `<?= $opcionesTelefonoHTML ?>`;

document.querySelectorAll('.telefono-row').forEach(row => {
    row.addEventListener('mouseenter', () => {
        row.querySelector('.telefono-input').readOnly = false;
        row.querySelector('.telefono-select').classList.remove('d-none');
        row.querySelector('.telefono-tipo-text').classList.add('d-none');
    });
    row.addEventListener('mouseleave', () => {
        row.querySelector('.telefono-input').readOnly = true;
        row.querySelector('.telefono-select').classList.add('d-none');
        row.querySelector('.telefono-tipo-text').classList.remove('d-none');
    });
});

function agregarCorreo() {
    document.getElementById('correos-container').insertAdjacentHTML('beforeend', `
    <div class="row g-2 mb-2">
        <div class="col-md-6"><input type="email" name="nuevo_correo[]" class="form-control" required></div>
        <div class="col-md-4"><input name="correo_desc[]" class="form-control" required></div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-secondary w-100"
            onclick="this.closest('.row').remove()">—</button>
        </div>
    </div>`);
}

function agregarTelefono() {
    document.getElementById('telefonos-container').insertAdjacentHTML('beforeend', `
    <div class="row g-2 mb-2">
        <div class="col-md-5"><input name="nuevo_telefono[]" class="form-control" required></div>
        <div class="col-md-5">
            <select name="telefono_tipo[]" class="form-select" required>${opcionesTelefono}</select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-secondary w-100"
            onclick="this.closest('.row').remove()">—</button>
        </div>
    </div>`);
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
