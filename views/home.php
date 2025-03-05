<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // El usuario está autenticado
    $user_id = $_SESSION['user_id'];
    $fk_role_id = $_SESSION['fk_role_id'];
    $full_name = $_SESSION['full_name'];
} else {

    header("Location: ../index.html");
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
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>

    <header class="py-3 back-color">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="#" class="navbar-brand">
                <img src="assets/logo.png" alt="ReservBook Logo" width="150"> <!--      logo     -->
            </a>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <form class="d-flex" role="search">
                        <label for="search" class="visually-hidden">Search Book</label>
                        <input id="search" class="form-control me-2" type="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-light btn-search" type="submit">Search</button>
                    </form>
                </div>
            </nav>


            <form class="d-flex">
                <button class="btn btn-outline-danger"> <a href=" ../backend/logout.php">Logouth</a> </button>
            </form>
        </div>
    </header>

    <main class="container mt-4 text-center">

        <!-- ACA VA TODO EL CONTENIDO -->

    </main>

    <footer class="back-color text-white text-center py-3 mt-5">
        <p>&copy; <!-- AÑO Y QUIENES LO DESARROLLARON --></p>
    </footer>

</body>

</html>