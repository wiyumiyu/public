<?php
$pageTitle = "Curva de Retención de Humedad";
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
        <label class="form-label">Tipo de muestra</label>
        <select class="form-select">
            <option>Intacta</option>
            <option>Disturbada</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Método</label>
        <select class="form-select">
            <option>Extractor de presión</option>
            <option>Cámara de Richards</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- DATOS INICIALES -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Datos iniciales de la muestra</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Peso anillo vacío (Pc)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso saturado (Phsat)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso seco (Ps)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Densidad aparente (g/cm³)</label>
        <input type="number" step="0.01" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- PRESIONES -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Pesos por nivel de presión</h4>

<div class="table-responsive">
<table class="table table-sm align-middle">
    <thead>
        <tr>
            <th>Presión (kPa)</th>
            <th>Peso equilibrado (Ph)</th>
            <th>Fecha</th>
            <th>Equipo</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ([33,50,1000,1500] as $p): ?>
        <tr>
            <td><?= $p ?></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm"></td>
            <td><input type="date" class="form-control form-control-sm"></td>
            <td><input type="text" class="form-control form-control-sm"></td>
            <td><input type="text" class="form-control form-control-sm"></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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

<!-- FUTURO: GRÁFICO -->
<div class="mt-4">
    <div class="alert alert-secondary">
        <i class="bi bi-graph-up"></i>
        La curva de retención se mostrará aquí automáticamente al guardar los datos.
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/curvatura_retencion/listado.php"
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
