<?php
$pageTitle = "Bitácora del Sistema";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE -->
    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <!-- CARD -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Registro de actividades del sistema</h5>

            <div class="text-muted fs-13">
                Historial completo de inserciones, actualizaciones, eliminaciones y accesos realizados por los usuarios.
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="border-bottom" style="border-color:rgba(255,255,255,0.15);">
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Fecha / Hora</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Usuario</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Acción</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Módulo</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">Descripción</th>
                            <th class="text-muted fw-bold py-2" style="font-size:0.9rem;">IP</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    // Datos ficticios para demostración
                    $log = [
                        ["fecha" => "2025-02-12 08:14:22", "user" => "freddy@ucr.ac.cr", "accion" => "INSERT", "modulo" => "Textura", "desc" => "Nueva muestra TX-25-004 registrada.", "ip" => "181.45.22.17"],
                        ["fecha" => "2025-02-12 09:01:10", "user" => "maria@ucr.ac.cr", "accion" => "UPDATE", "modulo" => "Resultados", "desc" => "Se corrigió el valor de porosidad en muestra 30214.", "ip" => "181.45.22.17"],
                        ["fecha" => "2025-02-12 09:15:55", "user" => "admin@ucr.ac.cr", "accion" => "DELETE", "modulo" => "Usuarios", "desc" => "Usuario carlos@ucr.ac.cr eliminado.", "ip" => "10.0.0.12"],
                        ["fecha" => "2025-02-11 16:40:08", "user" => "freddy@ucr.ac.cr", "accion" => "LOGIN", "modulo" => "Autenticación", "desc" => "Inicio de sesión exitoso.", "ip" => "181.45.22.17"],
                        ["fecha" => "2025-02-11 16:41:10", "user" => "freddy@ucr.ac.cr", "accion" => "LOGOUT", "modulo" => "Autenticación", "desc" => "Cierre de sesión.", "ip" => "181.45.22.17"],
                        ["fecha" => "2025-02-10 14:22:37", "user" => "laura@ucr.ac.cr", "accion" => "INSERT", "modulo" => "Controles", "desc" => "Consecutivo C-2025-004 creado.", "ip" => "10.0.0.15"],
                        ["fecha" => "2025-02-10 14:25:10", "user" => "laura@ucr.ac.cr", "accion" => "UPDATE", "modulo" => "Controles", "desc" => "Actualizadas densidades en control semanal.", "ip" => "10.0.0.15"],
                        ["fecha" => "2025-02-09 11:59:42", "user" => "admin@ucr.ac.cr", "accion" => "INSERT", "modulo" => "Usuarios", "desc" => "Nuevo usuario laura@ucr.ac.cr creado.", "ip" => "10.0.0.12"],
                        ["fecha" => "2025-02-08 10:02:19", "user" => "admin@ucr.ac.cr", "accion" => "UPDATE", "modulo" => "Sistema", "desc" => "Cambio de parámetros de retención de humedad.", "ip" => "10.0.0.12"],
                        ["fecha" => "2025-02-07 15:37:00", "user" => "maria@ucr.ac.cr", "accion" => "DELETE", "modulo" => "Textura", "desc" => "Eliminada muestra TX-25-001 por duplicado.", "ip" => "181.45.22.17"],
                    ];

                    foreach ($log as $l):
                    ?>

                    <tr class="border-bottom" style="border-color:rgba(255,255,255,0.07);">

                        <td><?= $l["fecha"] ?></td>
                        <td><?= $l["user"] ?></td>

                        <td class="fw-semibold" 
                            style="color:
                                    <?= $l['accion']=="INSERT"?'#198754':
                                       ($l['accion']=="UPDATE"?'#0d6efd':
                                       ($l['accion']=="DELETE"?'#d9534f':'#6c757d')) ?>;">
                            <?= $l["accion"] ?>
                        </td>

                        <td><?= $l["modulo"] ?></td>
                        <td><?= $l["desc"] ?></td>
                        <td><?= $l["ip"] ?></td>

                    </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
