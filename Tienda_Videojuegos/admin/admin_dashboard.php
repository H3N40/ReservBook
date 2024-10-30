<?php
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include 'config/db.php'; // Conexión a la base de datos

// Obtener la lista de videojuegos
$query = "SELECT * FROM videojuegos";
$result = mysqli_query($conn, $query);

// Si se elimina un videojuego
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM videojuegos WHERE id = $id";
    mysqli_query($conn, $delete_query);
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Videojuegos</title>
</head>
<body>
    <h2>Panel de Administración de Videojuegos</h2>
    <a href="agregar_videojuego.php">Agregar Nuevo Videojuego</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['Nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['descuento']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <a href="editar_videojuego.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="admin_dashboard.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este videojuego?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
