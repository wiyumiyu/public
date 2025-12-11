<?php
$pageTitle = "Detalle del Consecutivo Semanal – Controles de Calidad";
$id = $_GET['id'] ?? "C-0000";

$info = [
    "consecutivo" => $id,
    "generado_por" => "Freddy Blanco",
    "fecha" => "06/02/2025",
    "rango" => "200 – 214"
];

ob_start();
?>

<div class="container-fluid page-inner">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Control de Calidad – Consecutivo <?= $info['consecutivo'] ?></h1>
            <div class="text-muted fs-14">
                Generado por <strong><?= $info['generado_por'] ?></strong> ·
                Fecha: <strong><?= $info['fecha'] ?></strong> ·
                Solicitudes: <strong><?= $info['rango'] ?></strong>
            </div>
        </div>

        <a href="/pages/controles/listado.php" class="btn btn-secondary">
            ← Volver al listado
        </a>
    </div>

    <!-- TARJETAS -->
    <div class="row mb-4">
        <?php
        $tarjetas = [
            ["label" => "Muestras Evaluadas", "valor" => "24"],
            ["label" => "Promedio CV%", "valor" => "3.1%"],
            ["label" => "Desviación Estándar", "valor" => "0.08"],
            ["label" => "% Controles Aprobados", "valor" => "91%"]
        ];
        foreach ($tarjetas as $t):
        ?>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="height:120px;">
                <h6 class="fw-bold text-primary mb-1"><?= $t['label'] ?></h6>
                <h3 class="fw-bold"><?= $t['valor'] ?></h3>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- MINI GRAFICOS -->
    <h5 class="fw-bold mb-3">Indicadores de Control</h5>

    <div class="row mb-4">

        <?php
        $charts = [
            ["id" => "c1", "label" => "Densidad Aparente"],
            ["id" => "c2", "label" => "Densidad de Partículas"],
            ["id" => "c3", "label" => "Porosidad (%)"],
            ["id" => "c4", "label" => "Repetibilidad"],
            ["id" => "c5", "label" => "Coef. Variación (CV%)"],
            ["id" => "c6", "label" => "Dif. frente a estándar"],
        ];

        foreach ($charts as $c):
        ?>
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm">
                <h6 class="fw-semibold mb-2"><?= $c["label"] ?></h6>
                <canvas id="<?= $c["id"] ?>"></canvas>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <!-- TABLA NUEVA PARA CONTROLES -->
    <div class="card shadow-sm">
        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Resultados del Control de Calidad</h5>
            <div class="text-muted fs-13">
                Valores generados durante las pruebas de control, comparados contra el estándar.
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">
                            <th class="text-muted fw-bold py-2">Muestra</th>
                            <th class="text-muted fw-bold py-2">Parámetro</th>
                            <th class="text-muted fw-bold py-2">Valor obtenido</th>
                            <th class="text-muted fw-bold py-2">Valor referencia</th>
                            <th class="text-muted fw-bold py-2">Diferencia</th>
                            <th class="text-muted fw-bold py-2">CV %</th>
                            <th class="text-muted fw-bold py-2">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $parametros = ["D. Aparente", "D. Partículas", "Porosidad", "Repetibilidad"];

                        for ($i = 1; $i <= 16; $i++):
                            $param = $parametros[array_rand($parametros)];
                            $ref  = round(rand(120, 150) / 100, 2);
                            $obt  = round($ref + ((rand(-8, 8)) / 100), 2);
                            $dif  = round($obt - $ref, 2);
                            $cv   = round(abs($dif) * 10, 2);
                            $estado = $cv < 5 ? "Aprobado" : "En revisión";
                        ?>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.07);">
                            <td>M-<?= str_pad($i, 3, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $param ?></td>
                            <td><?= $obt ?></td>
                            <td><?= $ref ?></td>
                            <td><?= $dif ?></td>
                            <td><?= $cv ?>%</td>
                            <td><?= $estado ?></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- CHARTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function miniBar(ctx, data, color) {
    return new Chart(document.getElementById(ctx), {
        type: "bar",
        data: { labels:["A","B","C","D","E"], datasets:[{ data:data, backgroundColor:color }] },
        options:{ responsive:true, plugins:{legend:{display:false}} }
    });
}

function miniLine(ctx, data, color) {
    return new Chart(document.getElementById(ctx), {
        type: "line",
        data: { labels:["1","2","3","4","5"], datasets:[{ data:data, borderColor:color, fill:false, tension:0.3 }] },
        options:{ responsive:true, plugins:{legend:{display:false}} }
    });
}

function miniPie(ctx, data, colors) {
    return new Chart(document.getElementById(ctx), {
        type:"pie",
        data:{ labels:["+", "-"], datasets:[{ data:data, backgroundColor:colors }] },
        options:{ responsive:true }
    });
}

// Render mini-gráficos
miniBar("c1", [1.20,1.22,1.19,1.18,1.23], "#4e73df");
miniLine("c2", [2.64,2.63,2.66,2.67,2.65], "#1cc88a");
miniBar("c3", [48,52,50,55,53], "#36b9cc");
miniLine("c4", [0.03,0.04,0.02,0.03,0.05], "#f6c23e");
miniBar("c5", [3.2,2.9,3.5,3.1,2.8], "#e74a3b");
miniPie("c6", [82,18], ["#4e73df","#e74a3b"]);
</script>


<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
