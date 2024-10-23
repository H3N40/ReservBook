<?php
session_start();

// Verificar si hay productos en el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

// Calcular el total de productos y el precio total
$total = 0;
foreach ($carrito as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>

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
        <h2>Carrito de Compras</h2>

        <!-- Mostrar productos del carrito -->
        <?php if (count($carrito) > 0) { ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($carrito as $id => $producto) { ?>
                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td>$ <?php echo number_format($producto['precio'], 2, '.', ','); ?></td>
                        <td>
                            <!-- Formulario para actualizar la cantidad -->
                            <form action="actualizar_carrito.php" method="POST">
                                <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                                <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" min="1">
                                <button type="submit" class="btn btn-secondary btn-sm">Actualizar</button>
                            </form>
                        </td>
                        <td>$ <?php echo number_format($producto['precio'] * $producto['cantidad'], 2, '.', ','); ?></td>
                        <td>
                            <!-- Botón para eliminar un producto del carrito -->
                            <form action="eliminar_carrito.php" method="POST">
                                <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <h3>Total: $ <?php echo number_format($total, 2, '.', ','); ?></h3>

            <!-- Botón para proceder al pago -->
            <a href="checkout.php" class="btn btn-success">Proceder al Pago</a>

        <?php } else { ?>
            <p>No hay productos en el carrito.</p>
            <a href="index.php" class="btn btn-primary">Volver al Catálogo</a>
        <?php } ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
