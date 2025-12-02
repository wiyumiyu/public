<?php
// Título de la página
$pageTitle = "Academy";

// Contenido de la página
ob_start();
?>

<h1 class="fw-bold mb-3">Academy</h1>
<p>Contenido de ejemplo para la sección Academy.</p>

<!-- 🔴 LINK PARA CERRAR SESIÓN (solo para prueba) -->
<a href="/logout.php" class="btn btn-danger mt-3">
    <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
</a>

<?php
$content = ob_get_clean();

// Cargar el layout principal
include $_SERVER['DOCUMENT_ROOT'] . '/layouts/master.php';
?>
