<?php
$host = 'localhost';
$dbname = 'tiendavideojuegos';  // Cambia esto por el nombre de tu base de datos
$username = 'root';  // Usualmente es 'root' en XAMPP
$password = '';  // Por defecto, XAMPP no tiene contraseña para MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
