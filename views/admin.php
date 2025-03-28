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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ReservBook - Reserva y gestiona tus citas de manera fácil y rápida.">
    <title>ReservBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light back-color">
    <div class="container-fluid">
        <a href="#" class="navbar-brand">
            <img class="logo" src="assets/logo.p alt="ReservBook Logo" > <!--      logo     -->
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
                    <a class="btn btn-outline-light me-2 btn-login" href="./views/login.html">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light me-2 btn-register" href="./views/register.html">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4 text-center">

    <!-- ACA VA TODO EL CONTENIDO -->

</main>

<footer class="back-color text-white text-center py-3 mt-5">
    <p>&copy; Juan y Jhon J<!-- AÑO Y QUIENES LO DESARROLLARON --></p>
</footer>

<!-- Incluir Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>

</html>