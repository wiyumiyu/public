<?php
$pageTitle = "Gestión de Usuarios";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/usuarios/editar.php" class="btn btn-primary px-4">
            + Nuevo usuario
        </a>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Listado de usuarios del sistema</h5>
            <div class="text-muted fs-13">
                Usuarios autorizados a ingresar y operar en la plataforma.
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead>
                        <tr class="border-bottom" style="border-color:rgba(255,255,255,0.15);">

                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Nombre</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Correo</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Rol</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Estado</th>
                            <th class="text-muted fw-bold text-center py-2" style="font-size:0.9rem;">Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Lista ficticia
                        $users = [
                            ["nombre" => "María Rojas", "correo" => "maria@ucr.ac.cr", "rol" => "Analista", "estado" => "Activo"],
                            ["nombre" => "Freddy Blanco", "correo" => "freddy@ucr.ac.cr", "rol" => "Calidad", "estado" => "Activo"],
                            ["nombre" => "Carlos Jiménez", "correo" => "carlos@ucr.ac.cr", "rol" => "Administrador", "estado" => "Inactivo"],
                            ["nombre" => "Laura Solano", "correo" => "laura@ucr.ac.cr", "rol" => "Analista", "estado" => "Activo"],
                        ];

                        foreach ($users as $u):
                        ?>

                        <tr class="border-bottom" style="border-color:rgba(255,255,255,0.07);">

                            <td><?= $u["nombre"] ?></td>
                            <td class="fw-semibold" style="color:var(--bs-primary);"><?= $u["correo"] ?></td>
                            <td><?= $u["rol"] ?></td>
                            <td><?= $u["estado"] ?></td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- EDITAR -->
                                    <a href="/pages/usuarios/editar.php?correo=<?= urlencode($u['correo']) ?>"
                                       class="btn btn-sm"
                                       style="
                                            border: 1px solid #0d6efd;
                                            background-color: rgba(13,110,253,0.10);
                                            color: #0d6efd;
                                            border-radius: 8px;
                                            width: 38px;
                                            height: 38px;
                                            display:flex;
                                            justify-content:center;
                                            align-items:center;">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <button class="btn btn-sm"
                                            onclick="eliminarUsuario('<?= $u['correo'] ?>')"
                                            style="
                                                border:1px solid #d9534f;
                                                background-color:rgba(217,83,79,0.12);
                                                color:#d9534f;
                                                border-radius:8px;
                                                width:38px;
                                                height:38px;
                                                display:flex;
                                                justify-content:center;
                                                align-items:center;">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<script>
function eliminarUsuario(correo) {
    if (confirm("¿Eliminar el usuario: " + correo + "?")) {
        alert("Función no implementada aún.");
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
