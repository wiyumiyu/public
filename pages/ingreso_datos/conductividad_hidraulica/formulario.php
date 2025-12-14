<?php
$pageTitle = "Ensayo de Conductividad Hidráulica";
ob_start();
?>

<div class="container-fluid page-inner">

<h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

<form class="card p-4 shadow-sm">

<!-- ========================= -->
<!-- DATOS GENERALES -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Datos generales del ensayo</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Identificador de la muestra</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha del análisis</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Método</label>
        <select class="form-select">
            <option>Carga constante</option>
            <option>Carga variable</option>
            <option>Permeámetro de Guelph</option>
            <option>Otro</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Analista</label>
        <select class="form-select">
            <option>María Rojas</option>
            <option>Freddy Blanco</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Condición del suelo</label>
        <select class="form-select">
            <option>Saturado</option>
            <option>Compactado</option>
            <option>Disturbado</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- DATOS FÍSICOS -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Datos físicos de la muestra</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Longitud L (cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Diámetro D (cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Área A (cm²)</label>
        <input type="number" step="0.01" class="form-control" readonly>
    </div>

    <div class="col-md-3">
        <label class="form-label">Temp. agua (°C)</label>
        <input type="number" step="0.1" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- DATOS DE FLUJO -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Datos de flujo (Carga constante)</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Volumen Q (cm³)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Tiempo t (s)</label>
        <input type="number" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Carga h (cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Repetición</label>
        <input type="number" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- RESULTADOS -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Resultados</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">K individual</label>
        <input type="number" step="0.000001" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">K promedio</label>
        <input type="number" step="0.000001" class="form-control" readonly>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/conductividad_hidraulica/listado.php"
       class="btn btn-outline-secondary px-4">
        Regresar al listado
    </a>
</div>

</form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/master.php';
?>
