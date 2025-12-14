<?php
$pageTitle = "Registro de Humedad Gravimétrica";
ob_start();
?>

<div class="container-fluid page-inner">

<h1 class="fw-bold mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

<form class="card p-4 shadow-sm">

<!-- ============================= -->
<!-- DATOS GENERALES -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Datos del ensayo</h4>

<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Fecha del análisis</label>
        <input type="datetime-local" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Identificador de la muestra</label>
        <input type="text" class="form-control" placeholder="Ej: IDLAB-90501">
    </div>

    <div class="col-md-4">
        <label class="form-label">Tipo de muestra</label>
        <select class="form-select">
            <option>Campo</option>
            <option>Laboratorio</option>
            <option>Suelo disturbado</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Método de secado (°C)</label>
        <input type="number" class="form-control" value="105">
    </div>

    <div class="col-md-4">
        <label class="form-label">Analista responsable</label>
        <input type="text" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
    </div>

</div>

<hr class="my-4">

<!-- ============================= -->
<!-- REGISTRO DE PESOS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Registro de pesos</h4>

<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Peso cápsula vacía (Pc) [g]</label>
        <input type="number" step="0.01" class="form-control peso" id="pc">
    </div>

    <div class="col-md-4">
        <label class="form-label">Cápsula + suelo húmedo (Ph) [g]</label>
        <input type="number" step="0.01" class="form-control peso" id="ph">
    </div>

    <div class="col-md-4">
        <label class="form-label">Cápsula + suelo seco (Ps) [g]</label>
        <input type="number" step="0.01" class="form-control peso" id="ps">
    </div>

</div>

<hr class="my-4">

<!-- ============================= -->
<!-- RESULTADOS -->
<!-- ============================= -->
<h4 class="fw-semibold mb-3">Resultados calculados</h4>

<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Peso suelo húmedo (g)</label>
        <input type="text" class="form-control" id="psh" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Peso suelo seco (g)</label>
        <input type="text" class="form-control" id="pss" readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Humedad gravimétrica (%)</label>
        <input type="text" class="form-control fw-bold" id="humedad" readonly>
    </div>

</div>

<div class="alert alert-warning mt-3 d-none" id="alerta">
    ⚠️ El valor de humedad es inusualmente alto. Verifique los pesos ingresados.
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">Confirmar resultado</button>
    <a href="/pages/ingreso_datos/humedad_gravimetrica/listado.php"
       class="btn btn-outline-secondary px-4">
        Regresar al listado
    </a>
</div>

</form>
</div>

<script>
function calcular(){
    const pc = parseFloat(pcEl.value)||0;
    const ph = parseFloat(phEl.value)||0;
    const ps = parseFloat(psEl.value)||0;

    if(ps >= ph || pc >= ph || pc >= ps) return;

    const psh = ph - pc;
    const pss = ps - pc;
    const h = ((psh - pss) / pss) * 100;

    pshEl.value = psh.toFixed(2);
    pssEl.value = pss.toFixed(2);
    hEl.value   = h.toFixed(2);

    alerta.classList.toggle("d-none", h <= 80);
}

const pcEl=document.getElementById("pc"),
      phEl=document.getElementById("ph"),
      psEl=document.getElementById("ps"),
      pshEl=document.getElementById("psh"),
      pssEl=document.getElementById("pss"),
      hEl=document.getElementById("humedad"),
      alerta=document.getElementById("alerta");

document.querySelectorAll(".peso").forEach(i=>i.addEventListener("input",calcular));
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/master.php';
?>
