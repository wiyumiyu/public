<?php
$pageTitle = "Reporte de Ensayo – Resultados del Cliente";
ob_start();
?>

<!-- CSS COMPLETAMENTE AISLADO -->
<style>
/* Caja principal del reporte */
.report-wrapper {
    background: #ffffff !important;
    color: #000000 !important;
    padding: 40px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Forzar que TODO dentro de la caja sea negro */
.report-wrapper * {
    color: #000000 !important;
}

/* Encabezado */
.report-header img {
    height: 70px;
}

.report-header h5,
.report-header h6 {
    margin: 0;
    font-weight: bold;
}

/* Tabla */
.report-table th {
    background: #e6e6e6 !important;
    font-weight: bold !important;
}

.report-table th,
.report-table td {
    border: 1px solid #000 !important;
    padding: 6px;
    text-align: center;
    font-size: 13px;
}

/* Firmas */
.signature-box {
    margin-top: 40px;
    text-align: center;
}

.signature {
    width: 45%;
    display: inline-block;
    vertical-align: top;
    margin-top: 20px;
}

.signature p {
    margin: 2px 0;
}

/* Nota al final */
.footer-note {
    font-size: 12px;
    margin-top: 30px;
}
</style>



<div class="container-fluid page-inner">

    <div class="report-wrapper shadow-sm">

        <!-- ENCABEZADO -->
        <div class="d-flex justify-content-between align-items-center mb-4 report-header">

            <img src="../../assets/images/logo/logo_ucr.png">

            <div class="text-center">
                <h5>CIUDAD DE LA INVESTIGACIÓN</h5>
                <h6>LABORATORIO DE SUELOS Y FOLIARES</h6>
                <h5>REPORTE DE ENSAYO</h5>
                <span>RE-R01 (V2)</span>
            </div>

            <img src="../../assets/images/logo/logo_cia.png">

        </div>

        <!-- DATOS DEL CLIENTE -->
        <div class="row mb-4">

            <div class="col-md-6">
                <p><strong>N° DE REPORTE:</strong> 70012</p>
                <p><strong>USUARIO:</strong> Juan Pérez García</p>
                <p><strong>RESPONSABLE:</strong> Esteban Araya</p>
                <p><strong>TELÉFONO:</strong> 2279-6994</p>
            </div>

            <div class="col-md-6">
                <p><strong>PROVINCIA:</strong> Cartago</p>
                <p><strong>CANTÓN:</strong> Paraíso</p>
                <p><strong>LOCALIDAD:</strong> Orosi</p>
                <p><strong>CULTIVO:</strong> Chile Dulce</p>
            </div>

        </div>

        <!-- DATOS DEL ANÁLISIS -->
        <div class="row mb-4">

            <div class="col-md-6">
                <p><strong>ANÁLISIS:</strong> QC, B, S</p>
                <p><strong>FECHA DE RECEPCIÓN:</strong> 01/12/2020</p>
            </div>

            <div class="col-md-6">
                <p><strong>EMISIÓN DEL REPORTE:</strong> 09/12/2020</p>
                <p><strong>NÚMERO DE MUESTRAS:</strong> 3</p>
                <p><strong>PÁGINA:</strong> 1/1</p>
            </div>

        </div>

        <hr>

        <!-- TABLA -->
        <h5 class="fw-bold text-center mb-3">ANÁLISIS QUÍMICO FOLIAR</h5>

        <table class="table report-table">
            <thead>
                <tr>
                    <th>ID USUARIO</th>
                    <th>IDLAB</th>
                    <th>N</th>
                    <th>P</th>
                    <th>Ca</th>
                    <th>Mg</th>
                    <th>K</th>
                    <th>S</th>
                    <th>Fe</th>
                    <th>Cu</th>
                    <th>Zn</th>
                    <th>Mn</th>
                    <th>B</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>CHILE DULCE - LOTE 1</td>
                    <td>P-20-03170</td>
                    <td>4.28</td>
                    <td>0.19</td>
                    <td>1.51</td>
                    <td>0.32</td>
                    <td>5.36</td>
                    <td>0.68</td>
                    <td>148</td>
                    <td>74</td>
                    <td>207</td>
                    <td>504</td>
                    <td>178</td>
                </tr>

                <tr>
                    <td>CHILE DULCE - LOTE 2</td>
                    <td>P-20-03171</td>
                    <td>3.87</td>
                    <td>0.16</td>
                    <td>1.58</td>
                    <td>0.32</td>
                    <td>4.97</td>
                    <td>0.51</td>
                    <td>191</td>
                    <td>88</td>
                    <td>127</td>
                    <td>455</td>
                    <td>196</td>
                </tr>

                <tr>
                    <td>CHILE DULCE - LOTE 3</td>
                    <td>P-20-03172</td>
                    <td>3.51</td>
                    <td>0.16</td>
                    <td>1.29</td>
                    <td>0.16</td>
                    <td>4.52</td>
                    <td>0.42</td>
                    <td>142</td>
                    <td>69</td>
                    <td>114</td>
                    <td>411</td>
                    <td>204</td>
                </tr>
            </tbody>
        </table>

        <p class="text-center">— ÚLTIMA LÍNEA —</p>

        <!-- FIRMAS -->
        <div class="signature-box">

            <div class="signature">
                <p>_____________________________</p>
                <p><strong>B.Q. Marianella Blanco M.</strong><br>
                N.I. 2488<br>
                Gestora de Calidad</p>
            </div>

            <div class="signature">
                <p>_____________________________</p>
                <p><strong>Ing. Agr. Misael González A.</strong><br>
                N.I. 7827<br>
                Gestor Técnico</p>
            </div>

        </div>

        <!-- NOTAS -->
        <div class="footer-note">
            <p>
                1. Las unidades se expresan como se indican en las columnas.<br>
                2. Procedimiento estándar según método oficial.<br>
                3. Este informe no debe alterarse y el laboratorio no se responsabiliza de su mal uso.<br>
            </p>
        </div>

    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/master.php';
?>
