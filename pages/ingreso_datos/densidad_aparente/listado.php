<?php
$pageTitle = "Muestras de Densidad Aparente";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/ingreso_datos/densidad_aparente/formulario.php" class="btn btn-primary px-4">
            + Nueva muestra
        </a>
    </div>

    <!-- FILTER YEAR -->
    <div class="mb-4 d-flex align-items-center gap-3">
        <label class="fw-semibold mb-0">Año:</label>
        <select class="form-select w-auto" id="filtroAnio">
            <option>2025</option>
            <option>2024</option>
            <option>2023</option>
        </select>
    </div>

    <!-- ======== FABKIN BASIC TABLE ======== -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <!-- TITULO DE TABLA MÁS GRANDE -->
            <h5 class="card-title mb-1 fw-bold fs-5">Listado de muestras registradas</h5>

            <!-- DESCRIPCIÓN PARA DENSIDAD APARENTE -->
            <div class="text-muted fs-13">
                La densidad aparente describe la masa por unidad de volumen de un suelo seco no compactado. 
                Este registro reúne las muestras analizadas mediante el método del cilindro de volumen conocido.
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <!-- === HEADER ESTILO FABKIN CON TEXTO AGRANDADO === -->
                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">

                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Código</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Fecha</th>
                            <th class="text-muted fw-bold py-2" style="font-size: 0.9rem;">Analista</th>
                            <th class="text-muted fw-bold text-center py-2" style="font-size: 0.9rem;">Acciones</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // TEMPORAL — luego conectar a base de datos
                        $muestras = [
                            ["codigo" => "DA-25-001", "fecha" => "08/02/2025", "analista" => "Mariana Gómez"],
                            ["codigo" => "DA-25-002", "fecha" => "12/02/2025", "analista" => "Freddy Blanco"],
                            ["codigo" => "DA-25-003", "fecha" => "18/02/2025", "analista" => "Paula Hernández"],
                        ];

                        foreach ($muestras as $m):
                        ?>

                        <!-- FILA estilo FabKin -->
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.07);">

                            <!-- CÓDIGO -->
                            <td>
                                <a href="/pages/ingreso_datos/densidad_aparente/formulario.php?muestra=<?= urlencode($m['codigo']) ?>"
                                   class="fw-semibold"
                                   style="color: var(--bs-primary);">
                                   <?= htmlspecialchars($m['codigo']) ?>
                                </a>
                            </td>

                            <!-- FECHA -->
                            <td><?= htmlspecialchars($m['fecha']) ?></td>

                            <!-- ANALISTA -->
                            <td><?= htmlspecialchars($m['analista']) ?></td>

                            <!-- ACCIONES -->
                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <!-- EDITAR -->
                                    <a href="/pages/ingreso_datos/densidad_aparente/formulario.php?muestra=<?= urlencode($m['codigo']) ?>"
                                       class="btn btn-sm"
                                       style="
                                           border: 1px solid #ff7c32;
                                           background-color: rgba(255, 124, 50, 0.10);
                                           color: #ff7c32;
                                           border-radius: 8px;
                                           width: 38px;
                                           height: 38px;
                                           display: flex;
                                           justify-content: center;
                                           align-items: center;">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <button onclick="eliminarMuestra('<?= $m['codigo'] ?>')"
                                            class="btn btn-sm"
                                            style="
                                                border: 1px solid #d9534f;
                                                background-color: rgba(217, 83, 79, 0.12);
                                                color: #d9534f;
                                                border-radius: 8px;
                                                width: 38px;
                                                height: 38px;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
function eliminarMuestra(codigo) {
    if (confirm("¿Desea eliminar la muestra " + codigo + "?")) {
        alert("Eliminar no implementado aún.");
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/master.php';
?>
