<aside id="sidebar"
       class="bg-dark text-white sidebar shadow-sm"
       style="width:250px; min-height:100vh; transition:0.3s;">

    <div class="sidebar-header text-center py-4">
        <img src="/assets/images/logo-light.png" width="120">
    </div>

    <ul class="nav flex-column px-3">

        <li class="nav-item mb-2">
            <a href="/pages/dashboard.php" class="nav-link text-white">
                <i class="mdi mdi-view-dashboard-outline me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/pages/usuarios.php" class="nav-link text-white">
                <i class="mdi mdi-account-outline me-2"></i> Usuarios
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/pages/reportes.php" class="nav-link text-white">
                <i class="mdi mdi-chart-bar me-2"></i> Reportes
            </a>
        </li>

    </ul>
</aside>

<style>
/* Sidebar colapsable estilo Fabkin */
body.sidebar-collapsed #sidebar {
    width: 75px !important;
}

body.sidebar-collapsed #sidebar .nav-link {
    padding-left: 0 !important;
    justify-content: center !important;
}

body.sidebar-collapsed #sidebar .nav-link i {
    margin-right: 0 !important;
}

body.sidebar-collapsed #sidebar .nav-link span,
body.sidebar-collapsed #sidebar img {
    display: none !important;
}
</style>
