<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // El usuario está autenticado
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id']; 
    $nombre = $_SESSION['nombre']; 

    if ($role_id != 1) {
        // El usuario no tiene el rol 1, redirige a la página de dashboard
        header("Location: ./home.php"); // Cambia "dashboard.php" al nombre de tu página de dashboard
        exit();
    }

} else {

    header("Location: ../views/login.html");
    exit();
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">
    <title>ReservBook</title>
</head>
<body>
<!-- Contenedor principal -->
<div class="container-fluid">
    <!-- fila 1 -->
    <div class="row">
        <!-- fila 1 col 1 -->
        <div class="col-xs col-sm col-md col-lg">

            <nav class="navbar navbar-expand-lg navbar-light back-color">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand">
                        <img class="logo" src="../assets/logo.png" alt="ReservBook Logo"> <!--      logo     -->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <form class="d-flex" role="search">
                                    <label for="search" class="visually-hidden">Search Book</label>
                                    <input id="search" class="form-control me-2" type="search" placeholder="Search"
                                           aria-label="Search">
                                    <button class="btn btn-outline-light btn-search" type="submit">Search</button>
                                </form>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="btn btn-outline-light me-2 btn-logout" href="../backend/logout.php">Logout</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-light me-2 btn-admin" href="../views/admin.php">Admin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div> <!--Fin fila 1 col 1 -->
    </div> <!-- Fin fila 1 -->
    <!-- fila 2 -->





    </div> <!-- Fin fila 2 -->

    <!-- fila 3 -->





    

    </div> <!-- Fin fila 3 -->

    <!-- fila 4 -->
    <div class="row">
        <!-- fila 4 col 1 -->
        <div class="col-xs col-sm col-md-4 col-lg-4">
            <div class="p">libros</div>


        </div><!--Fin fila 4 col 1 -->
        <!-- fila 4 col 2 -->
        <div class="col-xs col-sm col-md-4 col-lg-4">
            <div class="p">libros</div>


        </div><!--Fin fila 4 col 2 -->
        <!-- fila 4 col 3 -->
        <div class="col-xs col-sm col-md-4 col-lg-4">
            <div class="p">libros</div>


        </div><!--Fin fila 4 col 3 -->
    </div> <!-- Fin fila 4 -->
</div>
<!-- Fin contenedor principal -->


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  -->
</body>

</html>


</html>