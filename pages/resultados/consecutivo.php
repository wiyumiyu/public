<?php
$pageTitle = "Resultados Semanales – Detalle del Consecutivo";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TÍTULO -->
    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <!-- CARD PRINCIPAL -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Listado general de análisis</h5>

            <div class="text-muted fs-13">
                Este reporte muestra los valores procesados para la semana correspondiente al consecutivo seleccionado.
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <!-- ENCABEZADO CON ESTILO FABKIN -->
                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">

                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">ID</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Arena (%)</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Limo (%)</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Arcilla (%)</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">D. Aparente</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">D. Partículas</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Porosidad (%)</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        // 20 registros ficticios demostrativos
                        for ($i = 1; $i <= 20; $i++) {

                            $arena = rand(30, 70);
                            $limo = rand(10, 40);
                            $arcilla = 100 - ($arena + $limo);
                            if ($arcilla < 5) $arcilla = rand(5, 25);

                            $Da = round(mt_rand(100, 150) / 100, 2);
                            $Dp = round(mt_rand(255, 275) / 100, 2);
                            $porosidad = round((1 - ($Da / $Dp)) * 100, 1);

                            // Clases para celdas según rangos
                            $classDa =
                                $Da > 1.35 ? "bg-warning text-dark fw-semibold" :
                                ($Da < 1.05 ? "bg-info text-dark fw-semibold" : "");

                            $classDp =
                                $Dp > 2.70 ? "bg-warning text-dark fw-semibold" :
                                ($Dp < 2.60 ? "bg-info text-dark fw-semibold" : "");

                            $classPor =
                                $porosidad > 60 ? "bg-warning text-dark fw-semibold" :
                                ($porosidad < 45 ? "bg-info text-dark fw-semibold" : "");

                            echo "
                            <tr class='border-bottom' style=\"border-color: rgba(255,255,255,0.07);\">
                                <td>$i</td>
                                <td>$arena</td>
                                <td>$limo</td>
                                <td>$arcilla</td>
                                <td class='$classDa'>{$Da}</td>
                                <td class='$classDp'>{$Dp}</td>
                                <td class='$classPor'>{$porosidad}</td>
                            </tr>";
                        }
                        ?>

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
