<?php
$pageTitle = "Controles de Calidad – Dashboard de Análisis";
ob_start();
?>

<div class="container-fluid page-inner">

    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <!-- ============================= -->
    <!--     TARJETAS DE RESUMEN       -->
    <!-- ============================= -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="fw-bold text-primary">Muestras Analizadas</h6>
                <h2 class="fw-bold">24</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="fw-bold text-primary">Promedio D. Aparente</h6>
                <h2 class="fw-bold">1.21 g/cm³</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="fw-bold text-primary">Promedio D. Partículas</h6>
                <h2 class="fw-bold">2.64 g/cm³</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center">
                <h6 class="fw-bold text-primary">% Porosidad Promedio</h6>
                <h2 class="fw-bold">54%</h2>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <!-- ============================= -->
    <!--        GRÁFICOS               -->
    <!-- ============================= -->
    <div class="row">

        <!-- GRÁFICO 1: Densidades -->
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <h5 class="fw-semibold mb-3">Comparación de Densidades</h5>
                <canvas id="densidadesChart"></canvas>
            </div>
        </div>

        <!-- GRÁFICO 2: Textura -->
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <h5 class="fw-semibold mb-3">Distribución Textural (Ejemplo)</h5>
                <canvas id="texturaChart"></canvas>
            </div>
        </div>

        <!-- GRÁFICO 3: Porosidad -->
        <div class="col-12 mb-4">
            <div class="card p-4 shadow-sm">
                <h5 class="fw-semibold mb-3">Porosidad por Muestra</h5>
                <canvas id="porosidadChart"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- ============================= -->
<!--       SCRIPTS CHART JS        -->
<!-- ============================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// =====================================
// GRÁFICO 1 — DENSIDADES
// =====================================
new Chart(document.getElementById('densidadesChart'), {
    type: 'bar',
    data: {
        labels: ['Muestra 1', 'Muestra 2', 'Muestra 3', 'Muestra 4'],
        datasets: [
            {
                label: 'Densidad Aparente (g/cm³)',
                data: [1.20, 1.18, 1.25, 1.22],
                backgroundColor: '#4e73df'
            },
            {
                label: 'Densidad de Partículas (g/cm³)',
                data: [2.65, 2.63, 2.67, 2.64],
                backgroundColor: '#1cc88a'
            }
        ]
    },
    options: { responsive: true }
});

// =====================================
// GRÁFICO 2 — TEXTURA
// =====================================
new Chart(document.getElementById('texturaChart'), {
    type: 'pie',
    data: {
        labels: ['Arena', 'Limo', 'Arcilla'],
        datasets: [{
            data: [52, 28, 20],
            backgroundColor: ['#f6c23e', '#36b9cc', '#e74a3b']
        }]
    }
});

// =====================================
// GRÁFICO 3 — POROSIDAD
// =====================================
new Chart(document.getElementById('porosidadChart'), {
    type: 'line',
    data: {
        labels: ['M1', 'M2', 'M3', 'M4', 'M5'],
        datasets: [{
            label: 'Porosidad (%)',
            data: [48, 52, 55, 50, 57],
            borderColor: '#858796',
            fill: false,
            tension: 0.2
        }]
    },
    options: { responsive: true }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
