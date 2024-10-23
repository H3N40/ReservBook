<?php
session_start();

// Verifica si el ID del producto fue enviado correctamente
if (isset($_POST['id_producto']) && is_numeric($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Verifica si ya hay un carrito en la sesión, si no lo hay, crea uno vacío
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = array();
    }

    // Verifica si el producto ya está en el carrito
    if (isset($carrito[$id_producto])) {
        // Si el producto ya está en el carrito, incrementa la cantidad
        $carrito[$id_producto]['cantidad'] += 1;
    } else {
        // Si el producto no está en el carrito, busca los detalles del producto en la base de datos
        require 'config/database.php';
        $db = new Database();
        $con = $db->conectar();

        // Preparar la consulta para obtener el producto por su ID
        $sql = $con->prepare("SELECT id, nombre, precio FROM videojuegos WHERE id=?");
        $sql->execute([$id_producto]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);

        // Verifica si se encontró el producto
        if ($producto) {
            // Agrega el producto al carrito, incluyendo el ID como parte del array de datos
            $carrito[$id_producto] = array(
                'id' => $producto['id'],  // Guardar el ID del producto en el array
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1
            );
        } else {
            // Si no se encontró el producto, maneja el error
            echo "Producto no encontrado.";
            exit;
        }
    }

    // Actualiza el carrito en la sesión
    $_SESSION['carrito'] = $carrito;

    // Redirigir de nuevo al catálogo
    header('Location: index.php');
    exit();
} else {
    // Si no se recibió un ID de producto válido
    echo "ID de producto no válido.";
    exit();
}
?>
