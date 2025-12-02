<?php
// Título que se verá en el <title> y en el h1
$pageTitle = "Registro de Hidrómetro";

// Capturamos el contenido de la página
ob_start();
?>

<div class="container-fluid page-inner">

    <h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <form class="card p-4 shadow-sm">

        <!-- ============================= -->
        <!--      REGISTRO INICIAL         -->
        <!-- ============================= -->
        <h4 class="fw-semibold mb-3">Registro inicial</h4>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Fecha del ensayo</label>
                <input type="datetime-local" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Identificador de la muestra</label>
                <input type="text" class="form-control" placeholder="Ej: IDLAB-001">
            </div>

            <div class="col-md-4">
                <label class="form-label">Peso del suelo seco (g)</label>
                <input type="number" step="0.01" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">Observaciones (opcional)</label>
                <textarea class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Temperatura inicial (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>

        </div>

        <hr class="my-4">

        <!-- ============================= -->
        <!--          REGISTRO BLANCO      -->
        <!-- ============================= -->
        <h4 class="fw-semibold mb-3">Registro del blanco</h4>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Lectura del hidrómetro del blanco</label>
                <input type="text" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Temperatura del blanco (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>
        </div>

        <hr class="my-4">

        <!-- ============================= -->
        <!--   REGISTROS DE HIDRÓMETRO     -->
        <!-- ============================= -->
        <h4 class="fw-semibold mb-3">Registro de lecturas del hidrómetro</h4>

        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Tiempo (ej. 30 s, 1 min, 6 min, 24 h)</label>
                <input type="text" class="form-control">
            </div>

            <!-- Lecturas crudas en 4 tiempos -->
            <div class="col-md-3">
                <label class="form-label">Lectura hidrómetro T1</label>
                <input type="number" step="0.01" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Lectura hidrómetro T2</label>
                <input type="number" step="0.01" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Lectura hidrómetro T3</label>
                <input type="number" step="0.01" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Lectura hidrómetro T4</label>
                <input type="number" step="0.01" class="form-control">
            </div>

            <!-- Temperaturas correspondientes a cada lectura -->
            <div class="col-md-3">
                <label class="form-label">Temperatura lectura T1 (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Temperatura lectura T2 (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Temperatura lectura T3 (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Temperatura lectura T4 (°C)</label>
                <input type="number" step="0.1" class="form-control">
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Guardar registro</button>
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
