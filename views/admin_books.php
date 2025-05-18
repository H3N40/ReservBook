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
    <link rel="stylesheet" href="../css/admin_books.css">
    <title>ReservBook</title>
</head>

<body>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">


<div class="d-flex">
    <nav class="sidebar d-flex flex-column flex-shrink-0 position-fixed">
        <button class="toggle-btn">
            <i class="fas fa-chevron-left"></i>
        </button>


        <div class="p-4">

            <p class="text-muted small hide-on-collapse">Dashboard</p>
        </div>

        <div class="nav flex-column">
            <a href="./view_admin.php" class="sidebar-link active text-decoration-none p-3">
                <i class="fas fa-home me-3"></i>
                <span class="hide-on-collapse">Inicio</span>
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
            <a href="#" class="sidebar-link text-decoration-none p-3">
                <i class="fas fa-gear me-3"></i>
                <span class="hide-on-collapse">Settings</span>
            </a>
        </div>

        <div class="profile-section mt-auto p-1">
            <div class="d-flex align-items-center">
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

        <div class="container">
            <div class="header">
                <h1>SELECCIONA EL LIBRO</h1>
            </div>

            <div id="booksContainer">
                <!-- Aquí se cargarán los libros dinámicamente -->
            </div>

        </div>
</div>


</main>

</div>



<!-- MODAL PARA EDITAR LIBRO -->
<!-- Modal para editar libro -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editBookForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookModalLabel">Editar Libro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Campo oculto para el id del libro -->
          <input type="hidden" id="editBookId" name="id" />

          <div class="mb-3">
            <label for="editTitle" class="form-label">Título</label>
            <input type="text" class="form-control" id="editTitle" name="title" required />
          </div>

          <div class="mb-3">
            <label for="editAuthor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="editAuthor" name="author" required />
          </div>

          <div class="mb-3">
            <label for="editPublisher" class="form-label">Editorial</label>
            <input type="text" class="form-control" id="editPublisher" name="publisher" />
          </div>

          <div class="mb-3">
            <label for="editYear" class="form-label">Año de Publicación</label>
            <input type="number" class="form-control" id="editYear" name="publication_year" min="0" max="2100" />
          </div>

          <div class="mb-3">
            <label for="editStock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="editStock" name="stock" min="0" />
          </div>

          <div class="mb-3">
            <label for="editCoverImage" class="form-label">URL de Portada</label>
            <input type="url" class="form-control" id="editCoverImage" name="cover_image" />
          </div>

          <div class="mb-3">
            <label for="editDescription" class="form-label">Descripción</label>
            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </form>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<script src="../js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/main.js"></script>
</body>

</body>

</html>