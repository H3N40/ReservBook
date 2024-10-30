<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config/db.php'; // Conexión a la base de datos

$id = $_GET['id'];
$query = "SELECT * FROM videojuegos WHERE id = $id";
$result = mysqli_query($conn, $query);
$videojuego = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $stock = $_POST['stock'];

    $update_query = "UPDATE videojuegos SET Nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', descuento = '$descuento', stock = '$stock' WHERE id = $id";
    mysqli_query($conn, $update_query);
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Videojuego</title>
</head>
<body>
    <h2>Editar Videojuego</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $videojuego['Nombre']; ?>" required><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $videojuego['descripcion']; ?></textarea><br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?php echo $videojuego['precio']; ?>" required><br>
        <label for="descuento">Descuento:</label>
        <input type="number" id="descuento" name="descuento" value="<?php echo $videojuego['descuento']; ?>"><br>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $videojuego['stock']; ?>" required><br>
        <button type="submit">Actualizar Videojuego</button>
    </form>
</body>
</html>
