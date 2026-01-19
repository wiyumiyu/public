<?php
$pageTitle = "Gestión de Usuarios";
ob_start();

require_once __DIR__ . '/../../includes/config.php';

/*
 |=====================================================
 | CONSULTA REAL A BASE DE DATOS
 |=====================================================
 | - Nombre completo
 | - Cédula
 | - Rol
 | - Estado (1=Activo, 0=Inactivo)
 */
$stmt = $pdo->prepare("CALL sp_listado_usuarios()");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

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
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Cédula</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Rol</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Estado</th>
                            <th class="text-muted fw-bold text-center py-2" style="font-size:0.9rem;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($users as $u): ?>
                                <tr class="border-bottom" style="border-color:rgba(255,255,255,0.07);">

                                    <td><?= htmlspecialchars($u['nombre_completo']) ?></td>

                                    <td class="fw-semibold" style="color:var(--bs-primary);">
                                        <?= htmlspecialchars($u['cedula']) ?>
                                    </td>

                                    <td><?= htmlspecialchars($u['rol'] ?? 'Sin rol') ?></td>

                                    <td>
                                        <?php if ($u['id_estado'] == 1): ?>
                                            <span class="badge bg-success-subtle text-success">
                                                Activo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger">
                                                Inactivo
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            <!-- EDITAR -->
                                            <a href="/pages/usuarios/editar.php?id=<?= $u['id_persona'] ?>"
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
                                                    onclick="eliminarUsuario(<?= $u['id_persona'] ?>)"
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

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<script>
function eliminarUsuario(id) {
    if (confirm("¿Eliminar el usuario seleccionado?")) {
        alert("Función no implementada aún.");
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
