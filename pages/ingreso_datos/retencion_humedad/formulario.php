<?php
$pageTitle = "Ensayo de Retención de Humedad";
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
        <label class="form-label">Fecha inicio</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Analista</label>
        <select class="form-select">
            <option>María Rojas</option>
            <option>Freddy Blanco</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Equipo utilizado</label>
        <select class="form-select">
            <option>Mesa de tensión</option>
            <option>Olla de presión</option>
            <option>Extractor</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Método</label>
        <select class="form-select">
            <option>Succión matricial</option>
            <option>Presión</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- PESOS -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Registro de pesos</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Peso cápsula/anillo (Pc)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso saturado (Phsat)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso a 33 kPa (Ph33)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso a 1500 kPa (Ph1500)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso seco (Ps)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Temp. secado (°C)</label>
        <input type="number" step="0.1" class="form-control" value="105">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- PARÁMETROS DE PRESIÓN -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Condiciones de presión</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Presión (kPa)</label>
        <select class="form-select">
            <option>33</option>
            <option>1500</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tiempo de equilibrio (h)</label>
        <input type="number" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Equipo / cámara</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Fecha inicio / fin</label>
        <input type="text" class="form-control" placeholder="Opcional">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- RESULTADOS -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Resultados calculados</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">H33 (%)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-3">
        <label class="form-label">H1500 (%)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-3">
        <label class="form-label">Agua disponible (%)</label>
        <input type="number" class="form-control" readonly>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/retencion_humedad/listado.php"
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
