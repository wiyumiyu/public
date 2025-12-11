<?php
$pageTitle = "Consecutivos Semanales – Resultados";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/resultados/consecutivo.php" class="btn btn-primary px-4">
            + Generar nuevo consecutivo
        </a>
    </div>

    <!-- ======== CARD: BASIC TABLE ======== -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Listado de consecutivos semanales</h5>

            <div class="text-muted fs-13">
                Cada consecutivo reúne todos los resultados procesados durante una semana, incluyendo solicitudes analizadas y responsables asignados.
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">

                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Consecutivo</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Generado por</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Fecha</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Rango de solicitudes</th>
                            <th class="text-muted fw-bold text-center py-2" style="font-size: 0.9rem;">Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // DEMO TEMPORAL — luego sustituir con BD real
                        $consecutivos = [
                            ["id" => "R-2025-001", "user" => "Freddy Blanco", "fecha" => "07/02/2025", "rango" => "100 – 118"],
                            ["id" => "R-2025-002", "user" => "María Rojas", "fecha" => "14/02/2025", "rango" => "119 – 140"],
                            ["id" => "R-2025-003", "user" => "Víctor Julio", "fecha" => "21/02/2025", "rango" => "141 – 160"],
                        ];

                        foreach ($consecutivos as $c):
                        ?>

                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.07);">

                            <td class="fw-semibold" style="color: var(--bs-primary);"><?= $c['id'] ?></td>
                            <td><?= $c['user'] ?></td>
                            <td><?= $c['fecha'] ?></td>
                            <td><?= $c['rango'] ?></td>

                            <!-- ACCIONES -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- VER -->
                                    <a href="/pages/resultados/consecutivo.php?id=<?= urlencode($c['id']) ?>"
                                       class="btn btn-sm"
                                       style="
                                            border: 1px solid #0d6efd;
                                            background-color: rgba(13, 110, 253, 0.10);
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
                                            onclick="eliminarConsecutivo('<?= $c['id'] ?>')"
                                            style="
                                                border: 1px solid #d9534f;
                                                background-color: rgba(217, 83, 79, 0.12);
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
function eliminarConsecutivo(id) {
    if (confirm("¿Eliminar el consecutivo " + id + "? Esta acción no se puede deshacer.")) {
        alert("Eliminación aún no implementada.");
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
