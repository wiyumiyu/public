<?php
require_once __DIR__ . '/../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: /login.php");
    exit;
}

$pageTitle   = $pageTitle   ?? 'Analisys Dashboard';
$breadcrumbs = $breadcrumbs ?? [];
$content     = $content     ?? '';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- CSS del template (Fabkin) -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet">
    <link href="/assets/css/app.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>

<body class="bg-body">

<?php include __DIR__ . '/topbar.php'; ?>

<div class="d-flex">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <main class="flex-grow-1 p-4">
        <?php if (!empty($breadcrumbs)) include __DIR__ . '/breadcrumbs.php'; ?>
        <?= $content ?>
    </main>
</div>
    
    <?php  include __DIR__ . '/footer.php'; ?>
   

<!-- JS del template -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/simplebar.min.js"></script>
<script src="/assets/js/waves.min.js"></script>
<script src="/assets/js/app.js"></script>

<script>
// ====== Sidebar: forzar funcionamiento del collapse ======
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar || typeof bootstrap === 'undefined') return;

    sidebar.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            // evitar que haga scroll al anchor
            e.preventDefault();

            const selector = this.getAttribute('href') || this.getAttribute('data-bs-target');
            if (!selector) return;

            const target = document.querySelector(selector);
            if (!target) return;

            const instance = bootstrap.Collapse.getOrCreateInstance(target);
            instance.toggle();
        });
    });
});
</script>


</body>
</html>

