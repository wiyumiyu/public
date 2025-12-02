<?php
// Título de la página
$pageTitle = "Academy";


// Contenido de la página
ob_start();
?>

<h1 class="fw-bold mb-3">Academy</h1>
<p>Contenido de ejemplo para la sección Academy.</p>

<?php
$content = ob_get_clean();

// Cargar el layout principal
include __DIR__ . '/../layouts/master.php';


?>