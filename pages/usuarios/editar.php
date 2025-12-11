<?php
$pageTitle = "Editar Usuario";
$correo = $_GET['correo'] ?? "";

// Datos ficticios si se está editando
$usuario = [
    "nombre" => "Usuario Nuevo",
    "correo" => $correo,
    "rol" => "Analista",
    "telefono" => "8888-8888",
    "estado" => "Activo"
];

ob_start();
?>

<div class="container-fluid page-inner">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= $correo ? "Editar Usuario" : "Nuevo Usuario" ?></h1>

        <a href="/pages/usuarios/listado.php" class="btn btn-secondary">
            ← Volver al listado
        </a>
    </div>

    <div class="card shadow-sm p-4">

        <form>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre completo</label>
                    <input type="text" class="form-control" value="<?= $usuario['nombre'] ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo (login)</label>
                    <input type="email" class="form-control" value="<?= $usuario['correo'] ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rol</label>
                    <select class="form-select">
                        <option <?= $usuario['rol']=="Analista"?"selected":"" ?>>Analista</option>
                        <option <?= $usuario['rol']=="Calidad"?"selected":"" ?>>Calidad</option>
                        <option <?= $usuario['rol']=="Administrador"?"selected":"" ?>>Administrador</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" value="<?= $usuario['telefono'] ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Estado</label>
                    <select class="form-select">
                        <option <?= $usuario['estado']=="Activo"?"selected":"" ?>>Activo</option>
                        <option <?= $usuario['estado']=="Inactivo"?"selected":"" ?>>Inactivo</option>
                    </select>
                </div>

                <hr class="mt-4">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nueva contraseña (opcional)</label>
                    <input type="password" class="form-control" placeholder="Cambiar contraseña">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control">
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
