<header class="navbar navbar-expand-lg topbar bg-dark text-white px-3 shadow-sm" style="height:70px;">
    
    <!-- ======== LEFT: SIDEBAR TOGGLE ======== -->
    <button class="btn btn-outline-secondary me-3" id="sidebarToggle">
        <i class="mdi mdi-menu"></i>
    </button>

    <!-- ======== LEFT NAVIGATION LINKS ======== -->
    <ul class="navbar-nav me-4">
        <!-- About -->
        <li class="nav-item me-3">
            <a href="#" class="nav-link text-white">About</a>
        </li>

        <!-- Authentication & Pages dropdown -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                Authentication & Pages
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Login</a></li>
                <li><a class="dropdown-item" href="#">Register</a></li>
                <li><a class="dropdown-item" href="#">Error 404</a></li>
            </ul>
        </li>

        <!-- Help -->
        <li class="nav-item">
            <a href="#" class="nav-link text-white">Help</a>
        </li>
    </ul>


    <!-- ======== RIGHT SIDE ICONS ======== -->
    <div class="ms-auto d-flex align-items-center">

        <!-- Search -->
        <button class="btn btn-sm btn-icon btn-light me-2">
            <i class="mdi mdi-magnify"></i>
        </button>

        <!-- Settings -->
        <button class="btn btn-sm btn-icon btn-light me-2">
            <i class="mdi mdi-cog"></i>
        </button>

        <!-- Notifications -->
        <button class="btn btn-sm btn-icon btn-light me-2">
            <i class="mdi mdi-bell"></i>
        </button>

        <!-- Light / Dark Mode -->
        <button class="btn btn-sm btn-icon btn-light me-3" id="modeToggle">
            <i class="mdi mdi-weather-night"></i>
        </button>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a class="d-flex align-items-center text-white text-decoration-none"
               href="#" data-bs-toggle="dropdown">
                <img src="/assets/images/avatar.png" width="35" class="rounded-circle me-2">
                <span><?= $_SESSION['user']['name'] ?? 'Usuario' ?></span>
                <i class="mdi mdi-chevron-down ms-1"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                <li><a class="dropdown-item" href="#">Configuración</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="/logout.php">
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>

    </div>
</header>

<script>
// Sidebar toggle
document.getElementById("sidebarToggle").onclick = () => {
    document.body.classList.toggle("sidebar-collapsed");
};

// Modo oscuro
document.getElementById("modeToggle").onclick = () => {
    const root = document.documentElement;
    root.dataset.bsTheme = root.dataset.bsTheme === "light" ? "dark" : "light";
};
</script>
