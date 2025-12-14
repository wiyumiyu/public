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
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- 🔥 AÑADIR AQUÍ: aplicar el tema ANTES de cargar CSS -->
    <script>
    (() => {
        const storedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', storedTheme);
    })();
    </script>

    <!-- CSS del template (Fabkin) -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/icons.min.css" rel="stylesheet">
    <link href="/assets/css/app.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    <link href="/assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
</head>


<body class="bg-body">

<?php include __DIR__ . '/topbar.php'; ?>

<div class="pe-layout">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="pe-content">
        <main class="p-4">
            <?= $content ?>
        </main>
    </div>
</div>
    
    
    
<?php  include __DIR__ . '/footer.php'; ?>
   

<!-- JS del template -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!--<script src="/assets/js/simplebar.min.js"></script>-->
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<!--<script src="/assets/js/waves.min.js"></script>-->
<script src="/assets/libs/node-waves/waves.min.js"></script>

<script src="/assets/js/app.js"></script>

<script>
// ====== Sidebar: forzar funcionamiento del collapse ======
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar || typeof bootstrap === 'undefined') return;

    sidebar.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault(); // ✅ corregido

            const selector = this.getAttribute('href') || this.getAttribute('data-bs-target');
            if (!selector) return;

            const target = document.querySelector(selector);
            if (!target) return;

            const instance = bootstrap.Collapse.getOrCreateInstance(target, {
                toggle: false // 👈 CLAVE
            });

            instance.toggle();
        });
    });
});
</script>

<script>
// ====== Mantener activo el menú actual y abrir el padre ======
document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.pathname;

    // Seleccionar todos los links del menú
    document.querySelectorAll(".pe-slide-item a.pe-nav-link").forEach(link => {
        const href = link.getAttribute("href");

        // Ignorar vacíos o javascript:void
        if (!href || href === "javascript:void(0)") return;

        // Si la URL actual contiene el href del link → este es el activo
if (
    currentUrl === href ||
    (href.includes("/pages/ingreso_datos/textura") &&
     currentUrl.includes("/pages/ingreso_datos/textura/")) ||
    (href.includes("/pages/ingreso_datos/densidad_aparente") &&
     currentUrl.includes("/pages/ingreso_datos/densidad_aparente/")) ||
    (href.includes("/pages/ingreso_datos/densidad_particulas") &&
     currentUrl.includes("/pages/ingreso_datos/densidad_particulas/")) ||
    (href.includes("/pages/ingreso_datos/porosidad_total") &&
     currentUrl.includes("/pages/ingreso_datos/porosidad_total/")) ||
    (href.includes("/pages/ingreso_datos/conductividad_hidraulica") &&
     currentUrl.includes("/pages/ingreso_datos/conductividad_hidraulica/"))||
    (href.includes("/pages/ingreso_datos/humedad_gravimetrica") &&
     currentUrl.includes("/pages/ingreso_datos/humedad_gravimetrica/")) || 
    (href.includes("/pages/ingreso_datos/retencion_humedad") &&
     currentUrl.includes("/pages/ingreso_datos/retencion_humedad/")) || 
    (href.includes("/pages/ingreso_datos/curvatura_retencion") &&
     currentUrl.includes("/pages/ingreso_datos/curvatura_retencion/")) || 
    (href.includes("/pages/ingreso_datos/granulometria_gruesa") &&
     currentUrl.includes("/pages/ingreso_datos/granulometria_gruesa/")) || 
    (href.includes("/pages/ingreso_datos/estabilidad_agregados") &&
     currentUrl.includes("/pages/ingreso_datos/estabilidad_agregados/"))  || 
    (href.includes("/pages/ingreso_datos/coel") &&
     currentUrl.includes("/pages/ingreso_datos/coel/")) || 
    (href.includes("/pages/ingreso_datos/permeabilidad_aire") &&
     currentUrl.includes("/pages/ingreso_datos/permeabilidad_aire/"))                
) {

            // 1. marcar hijo como activo
            link.classList.add("active");

            // 2. abrir menú padre
            const parentMenu = link.closest(".pe-slide-menu");
            if (parentMenu) {
                parentMenu.classList.add("show"); // muestra el collapse
            }

            // 3. marcar el enlace del padre como activo y expandido
            const parentTrigger = parentMenu?.previousElementSibling;
            if (parentTrigger && parentTrigger.classList.contains("pe-nav-link")) {
                parentTrigger.classList.add("active");
                parentTrigger.setAttribute("aria-expanded", "true");
            }
        }
    });
});
</script>

</body>
</html>

