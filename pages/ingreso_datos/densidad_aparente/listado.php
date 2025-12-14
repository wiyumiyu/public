<?php
$pageTitle = "Muestras de Densidad Aparente";
ob_start();
?>

<div class="container-fluid page-inner">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>

        <a href="/pages/ingreso_datos/densidad_aparente/formulario.php"
           class="btn btn-primary px-4">
            + Nueva muestra
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

    <div class="card shadow-sm">

        <div class="card-header pb-2">
            <h5 class="card-title mb-1 fw-bold fs-5">Ensayos registrados</h5>
            <div class="text-muted fs-13">
                La densidad aparente describe la masa por unidad de volumen del suelo seco,
                determinada mediante cilindros de volumen conocido.
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">

                    <thead>
                        <tr class="border-bottom">
                            <th class="fw-bold text-muted">Código</th>
                            <th class="fw-bold text-muted">Fecha</th>
                            <th class="fw-bold text-muted">Analista</th>
                            <th class="fw-bold text-muted text-center">Estado</th>
                            <th class="fw-bold text-muted text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $muestras = [
                            [
                                "codigo"=>"DA-25-001",
                                "fecha"=>"08/02/2025",
                                "analista"=>"Mariana Gómez",
                                "estado"=>"Finalizado"
                            ],
                            [
                                "codigo"=>"DA-25-002",
                                "fecha"=>"12/02/2025",
                                "analista"=>"Freddy Blanco",
                                "estado"=>"Borrador"
                            ],
                            [
                                "codigo"=>"DA-25-003",
                                "fecha"=>"18/02/2025",
                                "analista"=>"Paula Hernández",
                                "estado"=>"Borrador"
                            ]
                        ];

                        foreach ($muestras as $m):
                        ?>
                        <tr class="border-bottom">
                            <td class="fw-semibold text-primary">
                                <?= $m['codigo'] ?>
                            </td>

                            <td><?= $m['fecha'] ?></td>
                            <td><?= $m['analista'] ?></td>

                            <td class="text-center">
                                <span class="badge <?= $m['estado']==='Finalizado'?'bg-success':'bg-warning text-dark' ?>">
                                    <?= $m['estado'] ?>
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- EDITAR -->
                                    <a href="/pages/ingreso_datos/densidad_aparente/formulario.php?muestra=<?= $m['codigo'] ?>"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- ELIMINAR -->
                                    <button class="btn btn-sm btn-outline-danger"
                                            <?= $m['estado']==='Finalizado'?'disabled':'' ?>>
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
