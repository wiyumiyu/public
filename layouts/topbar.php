<?php
// Asegurar siempre ruta absoluta para el avatar
$avatar = $_SESSION['user']['avatar'] ?? '/assets/images/avatar/avatar-10.jpg';
?>

<header class="app-header" id="appHeader">
    <div class="container-fluid w-100">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <div class="d-inline-flex align-items-center gap-5">

                    <!-- LOGO (todas las rutas corregidas a absolutas) -->
                    <a href="/pages/dashboard.php" class="fs-18 fw-semibold">
                        <img height="30" class="header-sidebar-logo-default d-none" alt="Logo" src="/assets/images/logo/RecursosNaturales.svg">
                        <img height="30" class="header-sidebar-logo-light d-none" alt="Logo" src="/assets/images/logo/RecursosNaturales.svg">
                        <img height="30" class="header-sidebar-logo-small d-none" alt="Logo" src="/assets/images/logo/RecursosNaturales.svg">
                        <img height="30" class="header-sidebar-logo-small-light d-none" alt="Logo" src="/assets/images/logo/RecursosNaturales.svg">
                    </a>

                    <button type="button" class="vertical-toggle btn btn-light-light text-muted icon-btn fs-5 rounded-pill" id="toggleSidebar">
                        <i class="bi bi-arrow-bar-left header-icon"></i>
                    </button>

                    <button type="button" class="horizontal-toggle btn btn-light-light text-muted icon-btn fs-5 rounded-pill d-none" id="toggleHorizontal">
                        <i class="ri-menu-2-line header-icon"></i>
                    </button>
                </div>
            </div>

            <div class="flex-shrink-0 d-flex align-items-center gap-1">

                <!-- MODO CLARO / OSCURO -->
                <div class="dark-mode-btn" id="toggleMode">
                    <button class="btn header-btn active" id="lightModeBtn">
                        <i class="bi bi-brightness-high"></i>
                    </button>
                    <button class="btn header-btn" id="darkModeBtn">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </div>

                <!-- PERFIL -->
                <div class="dropdown pe-dropdown-mega d-none d-md-block">

                    <button class="header-profile-btn btn gap-1 text-start" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">

                        <span class="header-btn btn position-relative">
                            <!-- AVATAR FIJO DE LA BARRA (correcto con ruta absoluta) -->
                            <img src="/assets/images/avatar/dummy_avatar.jpg"
                                 alt="Avatar Image"
                                 class="img-fluid rounded-circle">
                            <span class="position-absolute translate-middle badge border border-light rounded-circle bg-success">
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </span>

                        <div class="d-none d-lg-block pe-2">
                            <span class="d-block mb-0 fs-13 fw-semibold">
                                <?= htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido1']) ?>
                            </span>
                            <span class="d-block mb-0 fs-12 text-muted">
                                <?= implode(', ', $_SESSION['roles']) ?>
                            </span>
                        </div>

                    </button>

                    <div class="dropdown-menu dropdown-mega-sm header-dropdown-menu p-3">
                        <a href="/pages/usuarios/editar.php?id=<?= $_SESSION['id_persona'] ?>&from=perfil">
                            <!-- HEADER DEL PERFIL -->
                            <div class="border-bottom pb-2 mb-2 d-flex align-items-center gap-2">

                                <img src="/assets/images/avatar/dummy_avatar.jpg"
                                     class="rounded-circle header-profile-user"
                                     alt="user-image"
                                     width="35" height="35">

                                <div>
                                    <h6 class="mb-0 lh-base">
                                        <?= htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido1']) ?>
                                    </h6>



                                    <p class="mb-0 fs-13 text-muted">
                                        Usuario del sistema
                                    </p>
                                </div>

                            </div>
                        </a> 
                        <ul class="list-unstyled mb-0">
                            <li>
                              
                                <a class="dropdown-item" href="/logout.php">
                                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
