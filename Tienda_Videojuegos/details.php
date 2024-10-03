<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
  echo 'Error al procesar la petición';
  exit;
} else {

  $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

  if ($token == $token_tmp) {

    $sql = $con->prepare("SELECT count(id) FROM videojuegos WHERE id=? AND activo=1");
    $sql->execute([$id]);
    if ($sql->fetchAll() > 0) {

      $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM videojuegos WHERE id=? AND activo=1 LIMIT 1");
      $sql->execute([$id]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $nombre = $row['nombre'];
      $descripcion = $row['descripcion'];
      $precio = $row['precio'];
      $descuento = $row['descuento'];
      $precio_desc = $precio - (($precio * $descuento) / 100);
      $dir_imagenes = 'imagenes/juegos/' . $id . '/';

      $rutaImg = $dir_imagenes . 'imagen.jpg';

      if (!file_exists($rutaImg)) {
        $rutaImg = 'imagenes/Juegos/no-photoo.jpg';
      }

      $imagenes = array();
      $dir = dir($dir_imagenes);

      while (($archivo = $dir->read()) !== false) {
        if ($archivo != 'imagen.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
          $imagenes[] = $dir_imagenes . $archivo;
        }
      }
      $dir->close();
    }
  } else {
    echo 'Error al procesar la peticion';
    exit;
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
              <li><a href="#" class="text-white">Email me</a></li>
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
        <a href="carrito.php" class="btn btn-primary me-2">Carrito</a>

        <!-- Botón de Desplegar más (lo marco por que me dio problemas, y puede que interfiera un un futuro)-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
          aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      </div>
    </div>
  </header>


  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-1">

          <div id="carouselImages" class="carousel slide">
            <div class="carousel-inner">
              <div class="carousel-item active">
              <img src="<?php echo $rutaImg; ?>" class="d-block w-100" >
              </div>

              <?php foreach ($imagenes as $img) { ?>
              <div class="carousel-item ">
              <img src="<?php echo $img; ?>" class="d-block w-100" >
              
              </div>
              <?php } ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#arouselImages" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          
        </div>
        <div class="col-md-6 order-md-2">
          <h2><?php echo $nombre; ?></h2>

        <?php if($descuento > 0) { ?>
          <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
          <h2>
            <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?> 
            <small class="text-success"><?php echo $descuento ?>% descuento</small>  
          </h2>

          <?php } else { ?>

          <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>

          <?php } ?>

          <p class="lead">
            <?php echo $descripcion; ?>
          </p>

          <div class="d-grid gap-3 col-10 mx-auto">
            <button class="btn btn-primary" type="button">Comprar ahora</button>
            <button class="btn btn-outline-primary" type="button">agregar al carrito</button>

          </div>
        </div>
      </div>
    </div>
  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
</body>

</html>