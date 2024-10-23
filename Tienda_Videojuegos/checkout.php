<?php
session_start();

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
$total = 0;

// Calcular el total del carrito
foreach ($carrito as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

// Si no hay productos en el carrito, redirigir al catálogo
if (empty($carrito)) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<header>
    <div class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <strong>Tienda Videojuegos</strong>
            </a>
            <a href="carrito.php" class="btn btn-primary">
                Carrito <span id="num_cart" class="badge bg-secondary"><?php echo count($carrito); ?></span>
            </a>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <h2>Resumen del Pedido</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($carrito as $producto) { ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td>$ <?php echo number_format($producto['precio'], 2, '.', ','); ?></td>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td>$ <?php echo number_format($producto['precio'] * $producto['cantidad'], 2, '.', ','); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <h3>Total: $ <?php echo number_format($total, 2, '.', ','); ?></h3>

        <!-- Formulario de confirmación de compra -->
        <form action="confirmar_compra.php" method="POST">
            <!-- Información del cliente -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de Envío</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <!-- Información de pago -->
            <h4>Información de Pago</h4>
            <div class="mb-3">
                <label for="tarjeta_nombre" class="form-label">Nombre en la Tarjeta</label>
                <input type="text" class="form-control" id="tarjeta_nombre" name="tarjeta_nombre" required>
            </div>
            <div class="mb-3">
                <label for="tarjeta_numero" class="form-label">Número de Tarjeta</label>
                <input type="text" class="form-control" id="tarjeta_numero" name="tarjeta_numero" pattern="\d{16}" maxlength="16" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="tarjeta_expiracion" class="form-label">Fecha de Expiración (MM/AA)</label>
                    <input type="text" class="form-control" id="tarjeta_expiracion" name="tarjeta_expiracion" pattern="\d{2}/\d{2}" maxlength="5" required>
                </div>
                <div class="col-md-6">
                    <label for="tarjeta_cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="tarjeta_cvv" name="tarjeta_cvv" pattern="\d{3}" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Confirmar Compra</button>
            <a href="carrito.php" class="btn btn-secondary mt-3">Volver al Carrito</a>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
