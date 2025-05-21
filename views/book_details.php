<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id'];
    $nombre = $_SESSION['nombre'];
} else {
    header("Location: ../index.html");
    exit();
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReservBook - Detalles del Libro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <link rel="stylesheet" href="../css/book_details.css" />
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light back-color">
    <div class="container-fluid">
        <a href="#" class="navbar-brand">
            <img class="logo" src="../assets/logo.png" alt="ReservBook Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="d-flex ms-3" role="search">
                <input id="search" class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" />
                <button class="btn btn-outline-light btn-search" type="submit">Buscar</button>
            </form>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="btn btn-outline-light btn-logout" href="../backend/logout.php">Cerrar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-admin" href="../views/view_admin.php">Vista admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenedor principal para detalles -->
<div id="bookDetailsContainer">
    <!-- Contenido dinámico del libro cargado con JS -->
</div>

<!-- Bootstrap Bundle con Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<!-- jQuery y Alertify -->
<script src="../js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>


<!-- Tu script principal -->
<script src="../js/main.js"></script>

</body>
</html>
