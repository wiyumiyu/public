<?php
$pageTitle = "Granulometría de la Fracción Gruesa";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/ingreso_datos/granulometria_gruesa/formulario.php"
           class="btn btn-primary px-4">
            + Nuevo ensayo
        </a>
    </div>

    <!-- FILTER -->
    <div class="mb-4 d-flex align-items-center gap-3">
        <label class="fw-semibold mb-0">Año:</label>
        <select class="form-select w-auto">
            <option>2025</option>
            <option>2024</option>
        </select>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">
                Ensayos registrados
            </h5>
            <div class="text-muted fs-13">
                Análisis granulométricos por tamizado para la determinación
                de la distribución de la fracción gruesa del suelo.
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.15);">
                            <th class="text-muted fw-bold py-2">Código</th>
                            <th class="text-muted fw-bold py-2">Fecha</th>
                            <th class="text-muted fw-bold py-2">Método</th>
                            <th class="text-muted fw-bold py-2">Analista</th>
                            <th class="text-muted fw-bold text-center py-2">Estado</th>
                            <th class="text-muted fw-bold text-center py-2">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $ensayos = [
                            ["codigo"=>"GG-25-001","fecha"=>"06/02/2025","metodo"=>"Tamizado en seco","analista"=>"Freddy Blanco","estado"=>"Borrador"],
                            ["codigo"=>"GG-25-002","fecha"=>"12/02/2025","metodo"=>"Tamizado en húmedo","analista"=>"María Rojas","estado"=>"Finalizado"],
                        ];

                        foreach ($ensayos as $e):
                        ?>
                        <tr class="border-bottom" style="border-color: rgba(255,255,255,0.07);">
                            <td class="fw-semibold text-primary"><?= $e['codigo'] ?></td>
                            <td><?= $e['fecha'] ?></td>
                            <td><?= $e['metodo'] ?></td>
                            <td><?= $e['analista'] ?></td>
                            <td class="text-center">
                                <span class="badge <?= $e['estado']==='Finalizado'?'bg-success':'bg-warning text-dark' ?>">
                                    <?= $e['estado'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/pages/ingreso_datos/granulometria_gruesa/formulario.php?ensayo=<?= $e['codigo'] ?>"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger"
                                            <?= $e['estado']==='Finalizado'?'disabled':'' ?>>
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/master.php';
?>
