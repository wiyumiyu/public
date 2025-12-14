<?php
$pageTitle = "Dashboard";
ob_start();

/* ===============================
   DATOS SIMULADOS
================================ */

// Usuario
$usuario = $_SESSION['user']['name'] ?? 'Usuario';

// Frases motivadoras
$frases = [
    "La calidad no es un acto, es un hábito.",
    "Cada análisis cuenta para una mejor decisión.",
    "La precisión de hoy es la confianza de mañana.",
    "Medir bien es producir mejor."
];
$fraseRandom = $frases[array_rand($frases)];

// Solicitudes
$totalSolicitudesAnual = 128;
$promedioSolicitudesMes = round($totalSolicitudesAnual / 12, 1);

// Reportes
$totalReportesAnual = 52;
$reportesPorSemana = round($totalReportesAnual / 52, 1);

// Controles
$totalControles = 312;
$controlesOK = 294;
$controlesObs = 18;
$porcentajeOK = round(($controlesOK / $totalControles) * 100);

// Muestras
$totalMuestras = 428;
$promedioMuestrasSemana = round($totalMuestras / 52, 1);

// Gráficos
$muestrasPorAnalisis = [
    "Textura" => 42,
    "D. Aparente" => 31,
    "D. Partículas" => 18,
    "Porosidad" => 22
];

$solicitudesSemana = [18, 22, 31, 27, 30];

// Usuarios activos
$usuariosActivos = [
    ["nombre" => "Freddy Blanco", "acciones" => 54],
    ["nombre" => "María Rojas", "acciones" => 41],
    ["nombre" => "Víctor Julio", "acciones" => 37],
    ["nombre" => "Esteban Araya", "acciones" => 29],
];

// Bitácora resumida
$actividad = [
    ["usuario"=>"Freddy Blanco","accion"=>"Insertó muestra","modulo"=>"Textura"],
    ["usuario"=>"María Rojas","accion"=>"Generó reporte","modulo"=>"Resultados"],
    ["usuario"=>"Víctor Julio","accion"=>"Editó control","modulo"=>"Controles"],
    ["usuario"=>"Esteban Araya","accion"=>"Eliminó solicitud","modulo"=>"Reportes"],
];
?>

<div class="container-fluid page-inner">

<!-- ===============================
     BIENVENIDA
================================ -->
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="fw-bold mb-1">Bienvenido, <?= htmlspecialchars($usuario) ?> 👋</h4>
            <p class="text-muted mb-2">
                Sistema <strong>Analisys</strong> — <?= $fraseRandom ?>
            </p>
            <a href="/pages/reporte/listado.php" class="btn btn-primary btn-sm">
                Ver reportes
            </a>
        </div>
        <i class="bi bi-clipboard-data fs-1 text-primary opacity-25"></i>
    </div>
</div>

<!-- ===============================
     KPI CARDS INTELIGENTES
================================ -->
<div class="row g-3 mb-4">

<div class="col-xl-3 col-md-6">
    <div class="card shadow-sm p-3">
        <h6 class="text-muted">Solicitudes</h6>
        <h2 class="fw-bold"><?= $totalSolicitudesAnual ?></h2>
        <small class="text-muted"><?= $promedioSolicitudesMes ?> por mes</small>
        <div class="progress mt-2" style="height:6px;">
            <div class="progress-bar bg-primary" style="width:<?= min($promedioSolicitudesMes*8,100) ?>%"></div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card shadow-sm p-3">
        <h6 class="text-muted">Reportes de resultados</h6>
        <h2 class="fw-bold"><?= $totalReportesAnual ?></h2>
        <small class="text-muted"><?= $reportesPorSemana ?> por semana</small>
        <canvas id="reportesMini" height="45"></canvas>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card shadow-sm p-3">
        <h6 class="text-muted">Controles de calidad</h6>
        <h2 class="fw-bold"><?= $totalControles ?></h2>
        <small class="text-muted"><?= $porcentajeOK ?>% OK</small>
        <div class="d-flex align-items-center gap-2 mt-2">
            <div class="progress flex-grow-1" style="height:6px;">
                <div class="progress-bar bg-success" style="width:<?= $porcentajeOK ?>%"></div>
            </div>
            <span class="fw-semibold text-success"><?= $porcentajeOK ?>%</span>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card shadow-sm p-3">
        <h6 class="text-muted">Muestras analizadas</h6>
        <h2 class="fw-bold"><?= $totalMuestras ?></h2>
        <small class="text-muted"><?= $promedioMuestrasSemana ?> por semana</small>
        <canvas id="muestrasMini" height="45"></canvas>
    </div>
</div>

</div>

<!-- ===============================
     GRÁFICOS MEDIOS
================================ -->
<div class="row g-3 mb-4">

<div class="col-md-4">
    <div class="card shadow-sm p-3 h-100">
        <h6 class="fw-semibold mb-3">Calidad de controles</h6>
        <h2 class="fw-bold mb-1"><?= $porcentajeOK ?>%</h2>
        <div class="progress mb-2" style="height:8px;">
            <div class="progress-bar bg-success" style="width:<?= $porcentajeOK ?>%"></div>
        </div>
        <small class="text-muted"><?= $controlesObs ?> con observaciones</small>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow-sm p-3">
        <h6 class="fw-semibold">Solicitudes por semana</h6>
        <canvas id="solicitudesChart" height="160"></canvas>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow-sm p-3">
        <h6 class="fw-semibold">Actividad diaria</h6>
        <canvas id="actividadChart" height="160"></canvas>
    </div>
</div>

</div>

<!-- ===============================
     GRÁFICO + TABLA
================================ -->
<div class="row g-3 mb-4">

<div class="col-lg-7">
    <div class="card shadow-sm p-3">
        <h6 class="fw-semibold">Muestras ingresadas por análisis</h6>
        <canvas id="muestrasChart" height="220"></canvas>
    </div>
</div>

<div class="col-lg-5">
    <div class="card shadow-sm">
        <div class="card-header fw-bold">Usuarios más activos</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Usuario</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                <?php foreach ($usuariosActivos as $u): ?>
                    <tr><td><?= $u['nombre'] ?></td><td><?= $u['acciones'] ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<!-- ===============================
     BITÁCORA
================================ -->
<div class="card shadow-sm">
    <div class="card-header fw-bold">Actividad reciente</div>
    <div class="card-body p-0">
        <table class="table table-sm table-hover mb-0">
            <thead>
                <tr><th>Usuario</th><th>Acción</th><th>Módulo</th></tr>
            </thead>
            <tbody>
            <?php foreach ($actividad as $a): ?>
                <tr>
                    <td><?= $a['usuario'] ?></td>
                    <td><?= $a['accion'] ?></td>
                    <td><?= $a['modulo'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(reportesMini,{type:'line',data:{labels:['S1','S2','S3','S4'],datasets:[{data:[1,1,2,1],borderColor:'#4e73df',tension:.4}]},options:{plugins:{legend:{display:false}},scales:{x:{display:false},y:{display:false}}}});
new Chart(muestrasMini,{type:'bar',data:{labels:['W1','W2','W3','W4'],datasets:[{data:[7,9,8,6],backgroundColor:'#1cc88a'}]},options:{plugins:{legend:{display:false}},scales:{x:{display:false},y:{display:false}}}});
new Chart(solicitudesChart,{type:'bar',data:{labels:['S1','S2','S3','S4','S5'],datasets:[{data:<?= json_encode($solicitudesSemana) ?>,backgroundColor:'#4e73df'}]},options:{plugins:{legend:{display:false}}}});
new Chart(actividadChart,{type:'line',data:{labels:['L','M','X','J','V','S'],datasets:[{data:[12,19,15,22,18,14],borderColor:'#36b9cc',tension:.3}]},options:{plugins:{legend:{display:false}}}});
new Chart(muestrasChart,{type:'bar',data:{labels:<?= json_encode(array_keys($muestrasPorAnalisis)) ?>,datasets:[{data:<?= json_encode(array_values($muestrasPorAnalisis)) ?>,backgroundColor:'#858796'}]},options:{plugins:{legend:{display:false}}}});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';
?>
