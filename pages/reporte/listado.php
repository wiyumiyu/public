<?php
$pageTitle = "Listado de Solicitudes de Reportes";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/reporte/reporte_v1.php" class="btn btn-primary px-4">
            + Crear reporte
        </a>
    </div>

    <!-- ======== CARD: BASIC TABLE ======== -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Solicitudes registradas</h5>

            <div class="text-muted fs-13">
                Cada solicitud corresponde a un reporte emitido o pendiente de emisión para un cliente.
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">

                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Solicitud</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Cliente</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Fecha</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Muestras</th>
                            <th class="text-muted fw-bold text-center py-2" style="font-size: 0.9rem;">Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // 10 solicitudes desde 90501
                        $solicitudes = [];
                        $clientes = ["Agrovalle S.A.", "Coop. Agrícola Norte", "Finca Santa Rosa", "Café Don Julio", "AgroSur", "Laboratorios T&F", "Productores Unidos", "Exportadora Verde", "Lácteos del Este", "AgroQuímica CR"];

                        for ($i = 0; $i < 10; $i++) {
                            $solicitudes[] = [
                                "id" => 90501 + $i,
                                "cliente" => $clientes[$i],
                                "fecha" => date("d/m/Y", strtotime("-" . rand(1, 15) . " days")),
                                "muestras" => rand(1, 6)
                            ];
                        }

                        foreach ($solicitudes as $s):
                        ?>

                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.07);">

                            <td class="fw-semibold" style="color: var(--bs-primary);">#<?= $s['id'] ?></td>
                            <td><?= $s['cliente'] ?></td>
                            <td><?= $s['fecha'] ?></td>
                            <td><?= $s['muestras'] ?></td>

                            <!-- ACCIONES -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- VER REPORTE -->
                                    <a href="/pages/reporte/reporte_v1.php?solicitud=<?= $s['id'] ?>"
                                       class="btn btn-sm"
                                       style="
                                            border: 1px solid #0d6efd;
                                            background-color: rgba(13,110,253,0.10);
                                            color: #0d6efd;
                                            border-radius: 8px;
                                            width: 38px;
                                            height: 38px;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <button class="btn btn-sm"
                                            onclick="eliminarSolicitud('<?= $s['id'] ?>')"
                                            style="
                                                border: 1px solid #d9534f;
                                                background-color: rgba(217,83,79,0.12);
                                                color: #d9534f;
                                                border-radius: 8px;
                                                width: 38px;
                                                height: 38px;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;">
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
function eliminarSolicitud(id) {
    if (confirm("¿Eliminar la solicitud #" + id + "? Esta acción no se puede deshacer.")) {
        alert("Función no implementada aún.");
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
