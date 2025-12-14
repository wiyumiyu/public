<?php
$pageTitle = "Ensayo de Granulometría – Fracción Gruesa";
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
            <option>Tamizado en seco</option>
            <option>Tamizado en húmedo</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tipo de material</label>
        <select class="form-select">
            <option>Suelo</option>
            <option>Grava</option>
            <option>Mezcla</option>
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
<h4 class="fw-semibold mb-3">Datos iniciales</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Peso total seco (Pt, g)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Peso bandeja / recipiente (opcional)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Fecha de secado</label>
        <input type="date" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Temp. / tiempo de secado</label>
        <input type="text" class="form-control" placeholder="105 °C / 24 h">
    </div>
</div>

<hr class="my-4">

<!-- ========================= -->
<!-- TAMICES -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Pesos retenidos por tamiz</h4>

<div class="table-responsive">
<table class="table table-sm align-middle">
    <thead>
        <tr>
            <th>Tamiz (mm)</th>
            <th>Peso retenido (g)</th>
            <th>% Retenido</th>
            <th>% Acumulado</th>
            <th>% Pasante</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $tamices = [19,9.5,4.75,2.0,1.0,0.5,0.25,0.125];
        foreach ($tamices as $t):
        ?>
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

<!-- ========================= -->
<!-- CURVA -->
<!-- ========================= -->
<h4 class="fw-semibold mb-3">Curva granulométrica</h4>

<div class="alert alert-secondary">
    <i class="bi bi-graph-up"></i>
    La curva granulométrica se generará automáticamente al completar los datos.
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/granulometria_gruesa/listado.php"
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
