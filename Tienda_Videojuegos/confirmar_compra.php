<?php
session_start();

// Verificar si hay productos en el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
if (empty($carrito)) {
    header('Location: index.php');
    exit;
}

// Obtener los datos enviados por el formulario
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$tarjeta_nombre = isset($_POST['tarjeta_nombre']) ? $_POST['tarjeta_nombre'] : '';
$tarjeta_numero = isset($_POST['tarjeta_numero']) ? $_POST['tarjeta_numero'] : '';
$tarjeta_expiracion = isset($_POST['tarjeta_expiracion']) ? $_POST['tarjeta_expiracion'] : '';
$tarjeta_cvv = isset($_POST['tarjeta_cvv']) ? $_POST['tarjeta_cvv'] : '';

// Validar que los datos del formulario estén completos
if (empty($nombre) || empty($direccion) || empty($correo) || empty($tarjeta_nombre) || empty($tarjeta_numero) || empty($tarjeta_expiracion) || empty($tarjeta_cvv)) {
    echo "Por favor, completa todos los campos del formulario.";
    exit;
}

// Función para generar claves de activación al estilo de Steam
function generarClaveActivacion() {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $clave = '';

    // Generar tres bloques de 5 caracteres separados por guiones
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $clave .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        if ($i < 2) {
            $clave .= '-';
        }
    }

    return $clave;
}

// Procesar la compra y generar claves de activación
$claves = array();
foreach ($carrito as $producto) {
    for ($i = 0; $i < $producto['cantidad']; $i++) {
        $claves[] = array(
            'nombre' => $producto['nombre'],
            'clave' => generarClaveActivacion()
        );
    }
}

// Limpiar el carrito después de la compra
$_SESSION['carrito'] = array();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>

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
        </div>
    </div>
</header>

<main class="container mt-5">
    <h2>Gracias por tu compra, <?php echo htmlspecialchars($nombre); ?>!</h2>
    <p>Se ha procesado tu pedido. A continuación se muestran las claves de activación para los juegos que compraste:</p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Juego</th>
            <th>Clave de Activación</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($claves as $clave) { ?>
            <tr>
                <td><?php echo htmlspecialchars($clave['nombre']); ?></td>
                <td><?php echo htmlspecialchars($clave['clave']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <p>Se enviará una confirmación de la compra y las claves a tu correo electrónico: <?php echo htmlspecialchars($correo); ?></p>

    <a href="index.php" class="btn btn-primary mt-3">Volver al Catálogo</a>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
