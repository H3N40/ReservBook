<?php
session_start();
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Verifica si ya hay un carrito en la sesión
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = array();
    }

    // Verifica si el producto ya está en el carrito
    if (isset($carrito[$id_producto])) {
        $carrito[$id_producto]['cantidad'] += 1;
    } else {
        // Aquí se debe obtener el producto de la base de datos
        require 'config/database.php';
        $db = new Database();
        $con = $db->conectar();

        $sql = $con->prepare("SELECT nombre, precio FROM videojuegos WHERE id=?");
        $sql->execute([$id_producto]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);

        // Agregar el producto al carrito
        $carrito[$id_producto] = array(
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => 1
        );
    }

    // Actualiza el carrito en la sesión
    $_SESSION['carrito'] = $carrito;

    // Redirigir de nuevo al catálogo
    header('Location: index.php');
    exit();
}
?>
