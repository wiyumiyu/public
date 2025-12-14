<?php
$pageTitle = "Ensayo de Estabilidad de Agregados";
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
        <label class="form-label">Método</label>
        <select class="form-select">
            <option>Yoder</option>
            <option>Le Bissonnais</option>
            <option>Otro</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tipo de muestra</label>
        <select class="form-select">
            <option>Intacta</option>
            <option>Disturbada</option>
            <option>Aire-seca</option>
            <option>Pre-húmeda</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- PESOS INICIALES -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Pesos iniciales</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Peso total de suelo seco (g)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Peso del conjunto de tamices (vacío)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha de inicio</label>
        <input type="datetime-local" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- PESOS POR TAMIZ -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Pesos retenidos por tamiz</h4>

<div class="table-responsive">
<table class="table table-sm align-middle">
    <thead>
        <tr>
            <th>Tamiz (mm)</th>
            <th>Peso retenido (g)</th>
            <th>% Retenido</th>
            <th>Fracción (wᵢ)</th>
            <th>Diámetro medio (xᵢ)</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ([2,1,0.5,0.25,'<0.25'] as $t): ?>
        <tr>
            <td><?= $t ?></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm"></td>
            <td><input type="number" class="form-control form-control-sm" readonly></td>
            <td><input type="number" class="form-control form-control-sm" readonly></td>
            <td><input type="number" class="form-control form-control-sm" readonly></td>
            <td><input type="text" class="form-control form-control-sm"></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- RESULTADOS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Resultados finales</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Diámetro Medio Ponderado (DMP, mm)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">% Agregados Estables al Agua (EAA)</label>
        <input type="number" class="form-control" readonly>
    </div>
</div>

<div class="alert alert-secondary mt-3">
    <i class="bi bi-info-circle"></i>
    Rangos típicos: DMP 0.5–3.0 mm | EAA 20–95 %
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/estabilidad_agregados/listado.php"
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
