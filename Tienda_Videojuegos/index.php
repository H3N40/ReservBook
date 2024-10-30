<?php
session_start();
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

// Consulta para obtener los productos activos
$sql = $con->prepare("SELECT id, nombre, precio FROM videojuegos WHERE activo=1 and stock >=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// Calcular la cantidad de productos en el carrito
$num_cart = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $num_cart += $producto['cantidad'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Videojuegos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<header>
    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">Sobre nosotros</h4>
                    <p class="text-muted">Somos un grupo de jóvenes amantes de los videojuegos y de la programación.</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Contacto</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Follow on Twitter</a></li>
                        <li><a href="#" class="text-white">Like on Facebook</a></li>
                        <li><a href="#" class="text-white">Email </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <strong>Tienda Videojuegos</strong>
            </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="#" class="nav-link active">Catálogo</a>
                </li>
            </ul>

            <!-- Mostrar la cantidad de productos en el carrito -->
            <a href="carrito.php" class="btn btn-primary">
                Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>

            <!-- Botón de Desplegar más -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </div>
</header>

<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($resultado as $row) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                        $id = $row['id'];
                        $imagen = "imagenes/Juegos/" . $id . "/imagen.jpg";

                        if (!file_exists($imagen)) {
                            $imagen = "imagenes/Juegos/no-photoo.jpg";
                        }
                        ?>
                        <img src="<?php echo $imagen; ?>" alt="Imagen del videojuego">
                        <div class="card-body">
                            <p class="card-title"><?php echo $row['nombre']; ?></p>
                            <h5 class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                </div>

                                <!-- Formulario para agregar productos al carrito -->
                                <form action="agregar_carrito.php" method="POST">
                                    <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
