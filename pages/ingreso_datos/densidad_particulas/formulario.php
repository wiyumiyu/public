<?php
$pageTitle = "Registro de Densidad de Partículas";
ob_start();
?>

<div class="container-fluid page-inner">

    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <form class="card p-4 shadow-sm">

        <!-- ============================= -->
        <!--      DATOS GENERALES          -->
        <!-- ============================= -->
        <h4 class="fw-semibold mb-3">Datos generales</h4>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Código de la muestra</label>
                <input type="text" class="form-control" placeholder="Ejemplo: DP-001">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Fecha del análisis</label>
                <input type="date" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Temperatura del agua (°C)</label>
                <input type="number" step="0.01" class="form-control" placeholder="Ej: 20">
            </div>
        </div>

        <hr class="my-4">

        <!-- ============================= -->
        <!--   DATOS DE LABORATORIO        -->
        <!-- ============================= -->
        <h4 class="fw-semibold mb-3">Datos de laboratorio</h4>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Masa del matraz vacío (g)</label>
                <input type="number" step="0.001" class="form-control" placeholder="Ej: 55.234">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Masa del matraz + suelo seco (g)</label>
                <input type="number" step="0.001" class="form-control" placeholder="Ej: 65.842">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Masa del matraz + agua + suelo (g)</label>
                <input type="number" step="0.001" class="form-control" placeholder="Ej: 124.567">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Volumen del matraz (mL)</label>
                <input type="number" step="0.1" class="form-control" placeholder="Ej: 100.0">
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Observaciones</label>
                <input type="text" class="form-control" placeholder="Notas o particularidades del análisis">
            </div>
        </div>

        <hr class="my-4">
        <div class="mt-4 d-flex gap-2">

           <!-- GUARDAR -->
           <button type="submit" class="btn btn-primary px-4">
               Guardar registro
           </button>

           <!-- REGRESAR AL LISTADO -->
           <a href="/pages/ingreso_datos/textura/listado.php"
              class="btn btn-outline-secondary px-4">
               Regresar al listado
           </a>

       </div>

           </form>

       </div>

<?php
// Cerramos el buffer y pasamos el contenido al layout
$content = ob_get_clean();

// OJO: estamos en public/pages/ingreso_datos/textura/
// hay que subir 3 niveles para llegar a public/layouts/master.php
include __DIR__ . '/../../../layouts/master.php';
?>
