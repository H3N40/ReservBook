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
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/view_admin.css">
    <title>ReservBook</title>
</head>

<body>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">


    <div class="d-flex flex-wrap">
        <nav class="sidebar d-flex flex-wrap flex-column flex-shrink-0 position-fixed">
            <button class="toggle-btn">
                <i class="fas fa-chevron-left"></i>
            </button>


            <div class="p-4">

                <p class="text-muted small hide-on-collapse">Dashboard</p>
            </div>

            <div class="nav flex-column">
                <a href="./view_admin.php" class="sidebar-link active text-decoration-none p-3">
                    <i class="fas fa-area-chart me-3"></i>
                    <span class="hide-on-collapse">Estadísticas</span>
                </a>
                <a href="./add_books.php" class="sidebar-link text-decoration-none p-3">
                    <i class="fas fa-book me-3"></i>
                    <span class="hide-on-collapse">Agregar Libros</span>
                </a>
                <a href="./admin_books.php" class="sidebar-link text-decoration-none p-3">
                    <i class="fas fa-book me-3"></i>
                    <span class="hide-on-collapse"> Libros</span>
                </a>
                <a href="admin_users.php" class="sidebar-link text-decoration-none p-3"> 
                    <i class="fas fa-users me-3"></i>
                    <span class="hide-on-collapse">Usuarios</span>
                </a>

                <a href="./add_users.php" class="sidebar-link text-decoration-none p-3">
                    <i class="fas fa-box me-3"></i>
                    <span class="hide-on-collapse">Agregar usuarios</span>
                </a>
                <a href="home.php" class="sidebar-link text-decoration-none p-3">
                    <i class="fas fa-home me-3"></i>
                    <span class="hide-on-collapse">Home</span>
                </a>
            </div>

            <div class="profile-section mt-auto p-1">
                <div class="d-flex flex-wrap align-items-center">
                    <img src="https://randomuser.me/api/portraits/women/70.jpg" style="height:60px"
                        class="rounded-circle" alt="Profile">
                    <div class="ms-3 profile-info">
                        <h6 class="text-white mb-0">Alex Morgan</h6>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </nav>




        <main class="main-content">
            <img src="../assets/libreria-admin.jpg" class="background-img" alt="Fondo">


            <div class="container-fluid text-center" id="welcome-section">
                    <div id="view-1-chart" class="view-section d-none">
                        <h2>Estadísticas de Accesos</h2>
                        <p class="text-muted">Cantidad de accesos de usuarios por fecha</p>
                        <canvas id="accessChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div id="view-2" class="view-section d-none">
                    <h2>Estadísticas rápidas</h2>
                    <p class="text-muted">Consulta el resumen de libros y usuarios activos.</p>
                </div>
                <div id="view-3" class="view-section d-none">
                    <h2>Configuración rápida</h2>
                    <p class="text-muted">Personaliza tu experiencia de administrador.</p>
                </div>
                <div id="view-4" class="view-section d-none">
                    <h2>Configuración </h2>
                    <p class="text-muted">Personaliza tu experiencia de administrador.</p>
                </div>
                <div id="view-5" class="view-section d-none">
                    <h2> rápida</h2>
                    <p class="text-muted">Personaliza tu experiencia de administrador.</p>
                </div>


                <button id="next-view" class="btn btn-light mt-4">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

    </div>


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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>