<?php
session_start();

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Verificar si el producto existe en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        // Eliminar el producto del carrito
        unset($_SESSION['carrito'][$id_producto]);
    }
}

// Redirigir de vuelta a la página del carrito
header('Location: carrito.php');
exit;
