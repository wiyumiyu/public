<?php
session_start();
require_once 'config.php';

function login($correo, $password) {
    global $pdo;

    $stmt = $pdo->prepare("CALL sp_login_persona(:correo)");
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if (!$rows) {
        return false;
    }

    $user = $rows[0];

    if (!password_verify($password, $user['contrasena'])) {
        return false;
    }

    // Datos base
    $_SESSION['id_persona'] = $user['id_persona'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['apellido1'] = $user['apellido1'];

    // Roles
    $_SESSION['roles'] = [];
    foreach ($rows as $row) {
        if (!empty($row['rol_nombre'])) {
            $_SESSION['roles'][] = $row['rol_nombre'];
        }
    }

    return true;
}


function isLoggedIn() {
    return isset($_SESSION['id_persona']);
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
