<?php
$pageTitle = "Gestión de Usuarios";
ob_start();

require_once __DIR__ . '/../../includes/config.php';

/* =====================================================
  ELIMINAR USUARIO (SOFT DELETE)
  ===================================================== */
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $idEliminar = (int) $_GET['eliminar'];

    $stmt = $pdo->prepare("CALL sp_eliminar_persona(?)");
    $stmt->execute([$idEliminar]);
    $stmt->closeCursor();

    header("Location: listado.php");
    exit;
}


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

        <a href="crear.php" class="btn btn-primary px-4">
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
                                                    onclick="confirmarEliminacionUsuario(<?= $u['id_persona'] ?>)"
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


    <!-- Modal Confirmar Eliminación Usuario -->
    <div class="modal fade" id="confirmDeleteUserModal"
         data-bs-backdrop="static"
         data-bs-keyboard="false"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        Eliminar usuario
                    </h5>
                    <button type="button"
                            class="btn-close icon-btn-sm"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="ri-close-large-line fw-semibold"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mb-0">
                        ¿Está seguro que desea eliminar este usuario?<br>
                        <small class="text-muted">
                            El usuario quedará inactivo en el sistema.
                        </small>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="button"
                            class="btn btn-danger"
                            id="confirmDeleteUserBtn">
                        Eliminar
                    </button>
                </div>

            </div>
        </div>
    </div>    
</div>

<script>
    let usuarioEliminar = null;

    function confirmarEliminacionUsuario(id) {
        usuarioEliminar = id;
        const modal = new bootstrap.Modal(
                document.getElementById('confirmDeleteUserModal')
                );
        modal.show();
    }

    document.getElementById('confirmDeleteUserBtn')
            .addEventListener('click', function () {
                if (usuarioEliminar) {
                    window.location.href =
                            window.location.pathname + '?eliminar=' + usuarioEliminar;
                }
            });
</script>


<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
