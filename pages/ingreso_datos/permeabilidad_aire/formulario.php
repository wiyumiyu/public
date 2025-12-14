<?php
$pageTitle = "Ensayo de Permeabilidad del Aire";
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
        <label class="form-label">Método / Equipo</label>
        <select class="form-select">
            <option>Presión constante</option>
            <option>Flujo variable</option>
            <option>Permeámetro de laboratorio</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tipo de muestra</label>
        <select class="form-select">
            <option>Intacta</option>
            <option>Compactada</option>
            <option>Disturbada</option>
            <option>Saturada</option>
            <option>Seca</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- PROPIEDADES FÍSICAS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Propiedades físicas de la muestra</h4>

<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label">Longitud (L, cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Diámetro (D, cm)</label>
        <input type="number" step="0.01" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Área (A, cm²)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-3">
        <label class="form-label">Volumen (cm³)</label>
        <input type="number" class="form-control" readonly>
    </div>

    <div class="col-md-3">
        <label class="form-label">Temperatura del aire (°C)</label>
        <input type="number" step="0.1" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Densidad aparente (opcional)</label>
        <input type="number" step="0.01" class="form-control">
    </div>
</div>

<hr class="my-4">

<!-- ============================= -->
<!-- MEDICIONES DE FLUJO -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Mediciones de flujo de aire</h4>

<div class="table-responsive mb-3">
<table class="table table-sm align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>ΔP</th>
            <th>Tiempo (s)</th>
            <th>Volumen Q</th>
            <th>Ka</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><input class="form-control form-control-sm"></td>
            <td><input class="form-control form-control-sm"></td>
            <td><input class="form-control form-control-sm"></td>
            <td class="text-muted">—</td>
            <td><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></td>
        </tr>
    </tbody>
</table>
</div>

<button type="button" class="btn btn-outline-secondary btn-sm mb-3">
    + Agregar medición
</button>

<hr>

<!-- ============================= -->
<!-- RESULTADOS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Resultados</h4>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Ka promedio</label>
        <input type="text" class="form-control" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Unidad</label>
        <select class="form-select">
            <option>m²</option>
            <option>cm²</option>
            <option>µm²</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Clasificación</label>
        <input type="text" class="form-control" readonly>
    </div>
</div>

<div class="alert alert-secondary mt-3">
    Rangos típicos: suelos arcillosos 10⁻⁹–10⁻⁷ m² | arenosos 10⁻⁷–10⁻⁵ m²
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        Guardar ensayo
    </button>

    <a href="/pages/ingreso_datos/permeabilidad_aire/listado.php"
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
