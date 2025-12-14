<?php
$pageTitle = "Ensayo de Coeficiente de Extensibilidad Lineal (COEL)";
ob_start();
?>

<div class="container-fluid page-inner">

<h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

<form class="card p-4 shadow-sm">

<!-- ============================= -->
<!-- DATOS GENERALES -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Datos generales del ensayo</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Identificador de la muestra</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha del ensayo</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Analista</label>
        <select class="form-select">
            <option>Freddy Blanco</option>
            <option>María Rojas</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Método empleado</label>
        <select class="form-select">
            <option>Cilindro</option>
            <option>Varilla</option>
            <option>Prisma</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tipo de muestra</label>
        <select class="form-select">
            <option>Intacta</option>
            <option>Compactada</option>
            <option>Disturbada</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- DIMENSIONES INICIALES -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Dimensiones iniciales (estado húmedo)</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Longitud húmeda (Lh, cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha y hora de medición</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Observaciones</label>
        <input type="text" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- DIMENSIONES FINALES -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Dimensiones finales (estado seco)</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Longitud seca (Ls, cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha y hora de medición</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Temperatura de secado (°C)</label>
        <input type="number" step="0.1" class="form-control" value="105">
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- RESULTADOS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Resultados calculados</h4>

<div class="table-responsive mb-3">
<table class="table table-sm">
    <thead>
        <tr>
            <th>Estado</th>
            <th>Longitud (cm)</th>
            <th>Diferencia (cm)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Húmedo</td>
            <td>Lh</td>
            <td rowspan="2">Lh − Ls</td>
        </tr>
        <tr>
            <td>Seco</td>
            <td>Ls</td>
        </tr>
    </tbody>
</table>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">COEL (decimal)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">COEL (%)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Clasificación</label>
        <input type="text" class="form-control" readonly>
    </div>
</div>

<div class="alert alert-secondary mt-3">
    <i class="bi bi-info-circle"></i>
    Valores &gt; 6 % indican suelos altamente expansivos.
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/coel/listado.php"
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
