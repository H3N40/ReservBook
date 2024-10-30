<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config/db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $stock = $_POST['stock'];

    $query = "INSERT INTO videojuegos (Nombre, descripcion, precio, descuento, stock) VALUES ('$nombre', '$descripcion', '$precio', '$descuento', '$stock')";
    mysqli_query($conn, $query);
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Videojuego</title>
</head>
<body>
    <h2>Agregar Videojuego</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required><br>
        <label for="descuento">Descuento:</label>
        <input type="number" id="descuento" name="descuento" value="0"><br>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br>
        <button type="submit">Agregar Videojuego</button>
    </form>
</body>
</html>

