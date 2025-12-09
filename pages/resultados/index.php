<?php
$pageTitle = "Reporte de Resultados";
ob_start();
?>

<div class="container-fluid page-inner">
    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <div class="card p-4 shadow-sm">

        <h4 class="fw-semibold mb-3">Listado general de análisis</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Arena (%)</th>
                        <th>Limo (%)</th>
                        <th>Arcilla (%)</th>
                        <th>D. Aparente</th>
                        <th>D. Partículas</th>
                        <th>Porosidad (%)</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    // 20 registros ficticios demostrativos
                    for ($i = 1; $i <= 20; $i++) {

                        // Simular datos realistas
                        $arena = rand(30, 70);
                        $limo = rand(10, 40);
                        $arcilla = 100 - ($arena + $limo);
                        if ($arcilla < 5) $arcilla = rand(5, 25);

                        $Da = round(mt_rand(100, 150) / 100, 2);      // 1.00 – 1.50
                        $Dp = round(mt_rand(255, 275) / 100, 2);      // 2.55 – 2.75
                        $porosidad = round((1 - ($Da / $Dp)) * 100, 1);

                        // Asignar clases según rangos
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
                        <tr>
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
