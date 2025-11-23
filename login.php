<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (login($email, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar sesión | Analisys</title>

    <!-- ================== ASSETS DEL FABKIN ================== -->
    <link href="http://analisys.lab/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="http://analisys.lab/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="http://analisys.lab/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="http://analisys.lab/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="http://analisys.lab/assets/css/custom.css" rel="stylesheet" type="text/css" /> <!-- opcional -->
    <link rel="shortcut icon" href="http://analisys.lab/assets/images/favicon.ico">
</head>

<body class="auth-body-bg">
    <div class="main-wrapper auth-wrapper d-flex align-items-center justify-content-center">
        <div class="auth-box p-4 shadow-lg rounded-4 bg-white text-center">
            <!-- Logo superior -->
            <div class="auth-logo mb-3">
                <img src="http://analisys.lab/assets/images/logo-light.png" alt="Logo" height="40">
            </div>

            <!-- Título y texto -->
            <h4 class="fw-bold mb-1">Bienvenido a <span class="text-primary">Analisys</span></h4>
            <p class="text-muted mb-4">Inicia sesión para continuar</p>

            <!-- Mensaje de error -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 mb-3"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Formulario -->
            <form method="POST" class="text-start">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email"
                           class="form-control"
                           required autofocus
                           value="<?= htmlspecialchars($email ?? '') ?>">
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">Contraseña</label>
                        <a href="#" class="small text-primary">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </div>
            </form>

            <!-- Pie de página -->
            <div class="text-muted mt-4 small">
                © <?= date('Y') ?> Analisys. Todos los derechos reservados.
            </div>
        </div>
    </div>

    <!-- ================== JS DEL FABKIN ================== -->
    <script src="http://analisys.lab/assets/js/bootstrap.bundle.min.js"></script>
    <script src="http://analisys.lab/assets/js/simplebar.min.js"></script>
    <script src="http://analisys.lab/assets/js/waves.min.js"></script>
    <script src="http://analisys.lab/assets/js/app.js"></script>
</body>
</html>
