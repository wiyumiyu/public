<?php
$pageTitle = "Dashboard";
$breadcrumbs = [
    ["label" => "Inicio",     "url" => "/pages/dashboard.php", "active" => false],
    ["label" => "Dashboard",  "url" => "", "active" => true],
];

ob_start();
?>

<h1 class="fw-bold mb-3">Dashboard</h1>
<p>Bienvenido al panel principal.</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/master.php';

?>



