<?php
require_once __DIR__ . '/../includes/auth.php';
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Analisys</title>

    <!-- CSS del template -->
    <link href="http://analisys.lab/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://analisys.lab/assets/css/icons.min.css" rel="stylesheet">
    <link href="http://analisys.lab/assets/css/app.min.css" rel="stylesheet">
    <link href="http://analisys.lab/assets/css/style.css" rel="stylesheet">
    <link href="http://analisys.lab/assets/css/custom.css" rel="stylesheet">
</head>

<body>

<!-- TOP BAR -->
<!--<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="navbar-brand fw-bold" href="index.php">Analisys</a>

    <div class="ms-auto">
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
</header>

<div class="d-flex">-->
