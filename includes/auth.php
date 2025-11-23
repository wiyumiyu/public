<?php
session_start();
require_once 'config.php';

function login($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
     
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        return true;
    } else {
        return false;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>