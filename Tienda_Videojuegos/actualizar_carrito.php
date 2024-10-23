<?php
session_start();

if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = intval($_POST['cantidad']);

    // Verificar si el producto existe en el carrito y la cantidad es válida
    if (isset($_SESSION['carrito'][$id_producto]) && $cantidad > 0) {
        // Actualizar la cantidad del producto en el carrito
        $_SESSION['carrito'][$id_producto]['cantidad'] = $cantidad;
    }
}

// Redirigir de vuelta a la página del carrito
header('Location: carrito.php');
exit;
