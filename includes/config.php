<?php

// Ruta base para los assets de la plantilla Fabkin
define('FABKIN_ASSETS', 'http://analisys.lab/assets/');

$host = 'localhost';
$db   = 'analisysbd';
$user = 'sysusuario';
$pass = 'wjdfeh64'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>