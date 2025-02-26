<?php
session_start(); 

if (isset( $_SESSION['logged_in'] ) &&  $_SESSION['logged_in'] === true ) {
       // El usuario está autenticado
       $userId = $_SESSION['user_id'];
       $roleId = $_SESSION['role_id'];
       $nombre = $_SESSION['nombre'];
}  else {


    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReservBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

<header class="py-2.4 back-color">
    <div class="container d-flex justify-content-between align-items-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>
        </nav>

        <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-danger"> <a href=" ../backend/logout.php">Logouth</a> </button>
                    
                </form>

    </div>
</header>
</body>


</html>