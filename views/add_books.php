<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/add_books.css">
    <title>ReservBook</title>


</head>

<body>
<!-- Contenedor principal -->
<div class="container-fluid">
    <!-- fila 1 -->
    <div class="row">

            <nav class="navbar navbar-expand-lg navbar-light back-color">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand">
                        <img class="logo" src="../assets/logo.png" alt="ReservBook Logo">
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
        </div>
    </div>

    <!-- fila 2 -->

    <div class="container">
        <div class="box effect7">
            <div class="header">INGRESAR LIBROS</div>
            <form id="booksForm">

                <div class="input-container">
                    <input type="text" placeholder="Ingrese el nombre del libro" name="title" required>
                </div>

                <div class="input-container">
                    <input type="text" placeholder="Ingrese el autor del libro" name="author" required>
                </div>

                <div class="input-container">
                    <input type="text" placeholder="Ingrese el nombre de la editorial" name="publisher" required>
                </div>

                <div class="input-container">
                    <input type="number" placeholder="Ingrese el año de publicacion del libro" name="publication_year"
                           required>
                </div>

                <div class="input-container">
                    <input type="text" placeholder="Ingrese el stock" name="stock" required>
                </div>

                <div class="input-container">
                    <input type="text" placeholder="Ingrese la url de la imagen de portada" name="cover_image" required>
                </div>

                <button type="submit" class="butt btn-register">Register</button>
            </form>
            <br>
            <!-- Botón Volver -->
            <a href="javascript:history.back()" class="btn-back">Volver</a>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script src="../js/jquery-3.7.1.min.js"></script>
<script src="../js/main.js"></script>
</body>

</html>
