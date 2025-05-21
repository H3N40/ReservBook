$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        var username = $.trim($('input[name="username"]').val());
        var password = $.trim($('input[name="password"]').val());

        password = encodeURIComponent(password);
        loginUser(username, password);
    });


    $("#registerForm").submit(function (event) {
        event.preventDefault();

        var fullName = $.trim($('input[name="full_name"]').val());
        var email = $.trim($('input[name="email"]').val());
        var password = $.trim($('input[name="password"]').val());
        var identificationNumber = $.trim($('input[name="identification_number"]').val());
        var phone = $.trim($('input[name="phone"]').val());

        if (fullName === "" || email === "" || password === "" || identificationNumber === "" || phone === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }


        registerUser(fullName, email, password, identificationNumber, phone);
    });


    $("#booksForm").submit(function (event) {
        event.preventDefault();

        var title = $.trim($('input[name="title"]').val());
        var author = $.trim($('input[name="author"]').val());
        var publisher = $.trim($('input[name="publisher"]').val());
        var publication_year = $.trim($('input[name="publication_year"]').val());
        var stock = $.trim($('input[name="cover_image"]').val());
        var cover_image = $.trim($('input[name="stock"]').val());
        var description = $.trim($('input[name="description"]').val());

        if (title === "" || author === "" || publisher === "" || publication_year === "" || stock === "" || cover_image === "" || description === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        cover_image = encodeURIComponent(cover_image);

        //console

        addbooks(title, author, publisher, publication_year, stock, cover_image, description);
    });


    $("#userForm").submit(function (event) {
        event.preventDefault();

        var full_name = $.trim($('input[name="full_name"]').val());
        var email = $.trim($('input[name="email"]').val());
        var password = $.trim($('input[name="password"]').val());
        var identification_number = $.trim($('input[name="identification_number"]').val());
        var phone = $.trim($('input[name="phone"]').val());
        var fk_role_id = $.trim($('#fk_role_id').val());

        if (full_name === "" || email === "" || password === "" || identification_number === "" || phone === "" || fk_role_id === null) {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        addUser(full_name, email, password, identification_number, phone, fk_role_id);
    });

});


//////////////////////////////////////////////          INICIAR SESIÓN USUARIO / INICIO          //////////////////////////////////////////////

function loginUser(username, password) {
    $.ajax({
        url: "../backend/login.php",
        method: "POST",
        data: { username: username, password: password },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alertify.success("login exitoso")
                setTimeout(() => {
                    window.location.href = "../views/home.php";
                }, 1000);
            } else if (response.status === "error") {
                alertify.error(response.message);
                $('input[name="username"]').val("");
                $('input[name="password"]').val("");
            } else {
                console.log("Otro error");
                $("#result").html("<p>Error en la llamada AJAX</p>");
            }
        },
    });
}

//////////////////////////////////////////////          INICIAR SESIÓN USUARIO / FIN          //////////////////////////////////////////////


//////////////////////////////////////////////          REGISTRAR USUARIO / INICIO          //////////////////////////////////////////////

function registerUser(fullName, email, password, identificationNumber, phone) {
    $.ajax({
        url: "../backend/register.php",
        method: "POST",
        data: {
            full_name: fullName,
            email: email,
            password: password,
            identification_number: identificationNumber,
            phone: phone
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alertify.success("Registro exitoso");
                setTimeout(() => {
                    window.location.href = "../views/login.html";
                }, 1000);
            } else if (response.status === "error") {
                alertify.error(response.message);
            } else {
                console.log("Otro error");
                $("#result").html("<p>Error en la llamada AJAX</p>");
            }
        },
    });
}

//////////////////////////////////////////////          REGISTRAR USUARIO / FIN          //////////////////////////////////////////////


//////////////////////////////////////////////          ADMIN BOOK / INICIO          //////////////////////////////////////////////
///////                                               AÑADIR,EDITAR Y ELIMINAR                                              ///////


function addbooks(title, author, publisher, publication_year, stock, cover_image, description) {
    $.ajax({
        url: "../backend/admin_books.php",
        method: "POST",
        data: {
            title: title,
            author: author,
            publisher: publisher,
            publication_year: publication_year,
            stock: stock,
            cover_image: cover_image,
            description: description
        },

        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alertify.success("El libro se ha ingresado correctamente");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (response.status === "error") {
                alertify.error(response.message);
            } else {
                console.log("Otro error");
                $("#result").html("<p>Error en la llamada AJAX</p>");
            }
        },
    });
}


$(document).ready(function () {
    $.ajax({
        url: "../backend/get_books.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var books = response.data;

                var booksContainer = $("#booksContainer");
                booksContainer.empty();

                if (books.length > 0) {
                    for (var i = 0; i < books.length; i++) {
                        booksContainer.append(`
                            <div class="book-item" id="book-${books[i].id}">
                                <div class="book-content">
                                    <img src="${books[i].cover_image}" alt="Portada" class="book-cover">
                                    <span class="book-title">${books[i].title}</span>
                                </div>
                                <div class="book-actions">
                                    <button class="edit_book-btn" data-id="${books[i].id}">Editar</button>
                                    <button class="delete_book-btn" data-id="${books[i].id}">Eliminar</button>
                                </div>
                            </div>
                        `);
                    }

                    $(".edit_book-btn").click(function () {
                        var bookId = $(this).data("id");
                        editBook(bookId);
                    });

                    $(".delete_book-btn").click(function () {
                        var bookId = $(this).data("id");
                        deleteBook(bookId);
                    });


                    $("#editBookForm").submit(function (event) {
                        event.preventDefault();

                        const bookId = $("#editBookId").val();
                        const title = $("#editTitle").val();
                        const author = $("#editAuthor").val();
                        const publisher = $("#editPublisher").val();
                        const year = $("#editYear").val();
                        const stock = $("#editStock").val();
                        const cover = $("#editCoverImage").val();
                        const description = $("#editDescription").val();

                        $.ajax({
                            url: "../backend/update_book.php",
                            method: "POST",
                            data: {
                                id: bookId,
                                title: title,
                                author: author,
                                publisher: publisher,
                                publication_year: year,
                                stock: stock,
                                cover_image: cover,
                                description: description
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.status === "success") {
                                    alertify.success("Libro actualizado correctamente");
                                    $("#editBookModal").modal("hide");
                                    location.reload();
                                } else {
                                    alertify.error(response.message);
                                }
                            },
                            error: function () {
                                alertify.error("Error al actualizar el libro.");
                            }
                        });
                    });

                } else {
                    booksContainer.html("<p>No hay libros registrados.</p>");
                }
            } else {
                alertify.error("Error al obtener los libros.");
            }
        },
        error: function () {
            alertify.error("Error de conexión al servidor.");
        }
    });

    //////////////////////////////////////////////          MOSTRAR LIBROS EN EL HOME / INICIO          //////////////////////////////////////////////

    $(document).ready(function () {
        function loadBooksForHome() {
            $.ajax({
                url: "../backend/get_books.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        var books = response.data;
                        var booksContainer = $("#booksHomeContainer");
                        booksContainer.empty();
                        if (books.length > 0) {
                            var row = $('<div class="row row-cols-2 row-cols-lg-5 g-4"></div>');
                            for (var i = 0; i < books.length; i++) {
                                row.append(`
                               
                                    <div class="card h-100">
                                        <img src="${books[i].cover_image}" class="card-img-top" alt="${books[i].title}">
                                        <div class="card-body">
                                            <h5 class="card-title">${books[i].title}</h5>
                                            <p class="card-text">${books[i].author}</p>
                                            <a href="book_details.php?id=${books[i].id}" class="btn btn-primary">Ver Detalles</a>
                                        </div>
                                    </div>
                            `);
                            }
                            booksContainer.append(row);
                        } else {
                            booksContainer.html('<div class="alert alert-info">No hay libros disponibles.</div>');
                        }
                    } else {
                        console.error("Error al obtener los libros:", response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error de conexión al servidor:", error);
                    $("#booksHomeContainer").html('<div class="alert alert-danger">Error al cargar los libros.</div>');
                }
            });
        }

        loadBooksForHome();


        //////////////////////////////////////////////          MOSTRAR LIBROS EN EL HOME / FIN          //////////////////////////////////////////////


        //////////////////////////////////////////////          MOSTRAR LIBROS EN EL INDEX / INICIO          //////////////////////////////////////////////

        function loadBooksForIndex() {
            $.ajax({
                url: "backend/get_books.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        var books = response.data;
                        var booksContainer = $("#booksIndexContainer");
                        booksContainer.empty();

                        if (books.length > 0) {
                            var row = $('<div class="row row-cols-2 row-cols-lg-5 g-4"></div>');
                            for (var i = 0; i < books.length; i++) {
                                row.append(`
                                    <div class="card h-100">
                                        <img src="${books[i].cover_image}" class="card-img-top" alt="${books[i].title}">
                                        <div class="card-body">
                                            <h5 class="card-title">${books[i].title}</h5>
                                            <p class="card-text">${books[i].author}</p>
                                            <a href="./views/login.html" class="btn btn-primary">Ver Detalles</a>
                                        </div>
                                    </div>
                            `);
                            }
                            booksContainer.append(row);
                        } else {
                            booksContainer.html('<div class="alert alert-info">No hay libros disponibles.</div>');
                        }
                    } else {
                        console.error("Error al obtener los libros:", response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error de conexión al servidor:", error);
                    $("#booksIndexContainer").html('<div class="alert alert-danger">Error al cargar los libros.</div>');
                }
            });
        }

        loadBooksForIndex();
    });


    //////////////////////////////////////////////          MOSTRAR LIBROS EN EL INDEX / FIN          //////////////////////////////////////////////


    function editBook(id) {
        $.ajax({
            url: "../backend/get_book_by_id.php",
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    const book = response.data;
                    $("#editBookId").val(book.id);
                    $("#editTitle").val(book.title);
                    $("#editAuthor").val(book.author);
                    $("#editPublisher").val(book.publisher);
                    $("#editYear").val(book.publication_year);
                    $("#editStock").val(book.stock);
                    $("#editCoverImage").val(book.cover_image);
                    $("#editDescription").val(book.description);

                    $("#editBookModal").modal("show");
                } else {
                    alertify.error("No se encontró el libro.");
                }
            },
            error: function () {
                alertify.error("Error al buscar el libro.");
            }
        });
    }
});


function deleteBook(id) {
    console.log(id);
    alertify.confirm("Eliminar libro", "¿Estás seguro de que quieres eliminar este libro?", function () {
        $.ajax({
            url: "../backend/delete_book.php",
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status === "success") {
                    alertify.success("Libro eliminado con éxito.");
                    location.reload();
                } else {
                    alertify.error(response.message);
                }
            },
            error: function () {
                alertify.error("Error al eliminar el libro.");
            }
        });
    }, function () {
        alertify.error("Eliminación cancelada.");
    });
}

//////////////////////////////////////////////          ADMIN BOOKS / FIN          //////////////////////////////////////////////

//////////////////////////////////////////////          BOOKS DETAILS / INICIO     //////////////////////////////////////////////


$(document).ready(function () {
    function loadBookDetails() {
        const params = new URLSearchParams(window.location.search);
        const bookId = params.get("id");

        if (!bookId) {
            $("#bookDetailsContainer").html('<div class="alert alert-danger">ID de libro no proporcionado.</div>');
            return;
        }

        $.ajax({
            url: "../backend/get_book_by_id.php",
            method: "POST",
            data: { id: bookId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    const book = response.data;
                    renderBookDetails(book);
                } else {
                    $("#bookDetailsContainer").html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            },
            error: function () {
                $("#bookDetailsContainer").html('<div class="alert alert-danger">Error al cargar los detalles del libro.</div>');
            }
        });
    }


    function renderBookDetails(book) {
        const card = `
        <div class="container-fluid full-screen-book">
            <div class="row g-0">
                <!-- Columna de la portada -->
                <div class="col-lg-6 book-cover-container">
                    <img src="${book.cover_image || 'default_cover.jpg'}" class="book-cover-img" alt="${book.title}">
                </div>
                
                <!-- Columna de detalles -->
                <div class="col-lg-6 book-details-container">
                    <h1 class="book-title">${book.title}</h1>
                    
                    <div class="book-meta">
                        <p><strong>Autor:</strong> ${book.author || 'No especificado'}</p>
                        <p><strong>Editorial:</strong> ${book.publisher || 'No especificada'}</p>
                        <p><strong>Año de publicación:</strong> ${book.publication_year || 'No especificado'}</p>
                        <p><strong>Estado:</strong> 
                            <span class="availability-badge badge ${book.stock > 0 ? 'bg-success' : 'bg-danger'}">
                                ${book.stock > 0 ? "Disponible" : "Agotado"}
                            </span>
                        </p>
                    </div>
                    
                    <div class="book-description">
                        <h5>Descripción</h5>
                        <p>${book.description || 'No hay descripción disponible.'}</p>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="../views/home.php" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Volver al catálogo
                        </a>
                        ${book.stock > 0
                            ? `<button class="btn btn-primary btn-lg" id="reserveBookBtn" data-book-id="${book.id}">
                                <i class="bi bi-bookmark-check me-2"></i>Reservar libro
                               </button>`
                            : ''}
                    </div>
                </div>
            </div>
        </div>
        `;

        $("#bookDetailsContainer").html(card);
    }


    $(document).on('click', '#reserveBookBtn', function () {
        const bookId = $(this).data('book-id');

        alertify.confirm(
            'Confirmar reserva',
            '¿Estás seguro de que deseas reservar este libro?',
            function () {
                reserveBook(bookId);
            },
            function () {
                alertify.message('Reserva cancelada');
            }
        ).set('labels', { ok: 'Confirmar reserva', cancel: 'Cancelar' });
    });


    function reserveBook(bookId) {
        $.ajax({
            url: '../backend/reserve.php',
            method: 'POST',
            data: { book_id: bookId },
            dataType: 'json',
            beforeSend: function() {
                alertify.message('Procesando reserva...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    alertify.success(response.message);

                    $('.availability-badge')
                        .removeClass('bg-success')
                        .addClass('bg-secondary')
                        .text('Reservado');
                    $('#reserveBookBtn').remove();
                } else {
                    alertify.error(response.message);
                }
            },
            error: function () {
                alertify.error('Error en la solicitud de reserva. Intente nuevamente.');
            }
        });
    }


    loadBookDetails();
});

//////////////////////////////////////////////          BOOKS DETAILS / FIN         //////////////////////////////////////////////





//////////////////////////////////////////////          MUESTRA LA TABLA DE LIBROS RESERVADOS EN EL PANEL ADMIN / INICIO         //////////////////////////////////////////////
function loadReservations() {
    $.ajax({
        url: '../backend/get_reservations.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let html = `
                    <h3 class="mt-4">Reservas realizadas</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Usuario</th>
                                <th>Fecha de reserva</th>
                                <th>Acciones</th> <!-- Nueva columna para botones -->
                            </tr>
                        </thead>
                        <tbody>`;

                response.data.forEach(reservation => {
                    html += `
                        <tr>    
                            <td>${reservation.book_title}</td>
                            <td>${reservation.user_name}</td>
                            <td>${reservation.reserved_at}</td>
                            <td>
                                <button class="btn btn-success btn-sm markBorrowedBtn" data-id="${reservation.id}">Marcar como prestado</button>
                                <button class="btn btn-danger btn-sm cancelReservationBtn" data-id="${reservation.id}">Cancelar reserva</button>
                            </td>
                        </tr>`;
                });

                html += `</tbody></table>`;
                $('#adminReservationsContainer').html(html);
            } else {
                $('#adminReservationsContainer').html(`<div class="alert alert-danger">${response.message}</div>`);
            }
        },
        error: function () {
            $('#adminReservationsContainer').html(`<div class="alert alert-danger">Error al cargar las reservas.</div>`);
        }
    });
}

loadReservations();

$(document).on('click', '.markBorrowedBtn', function () {
    const reservaId = $(this).data('id');

    $.ajax({
        url: '../backend/mark_borrowed.php',
        method: 'POST',
        data: { reserva_id: reservaId },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alertify.success(response.message);
                loadReservations();
            } else {
                alertify.error(response.message);
            }
        }
    });
});

$(document).on('click', '.cancelReservationBtn', function () {
    const reservaId = $(this).data('id');

    alertify.confirm(
        'Cancelar reserva',
        '¿Estás seguro de que deseas cancelar esta reserva?',
        function () {
            $.ajax({
                url: '../backend/cancel_reservation.php',
                method: 'POST',
                data: { reserva_id: reservaId },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alertify.success(response.message);
                        loadReservations();
                    } else {
                        alertify.error(response.message);
                    }
                },
                error: function () {
                    alertify.error('Error al cancelar la reserva');
                }
            });
        },
        function () {
            alertify.message('Cancelación de reserva abortada');
        }
    );
});


//////////////////////////////////////////////          MUESTRA LA TABLA DE LIBROS RESERVADOS EN EL PANEL ADMIN / FIN         //////////////////////////////////////////////









//////////////////////////////////////////////          CARGA LIBROS PRESTADOS EN PANEL ADMIN / INICIO         //////////////////////////////////////////////

function loadBorrowedBooks() {
    $.ajax({
        url: '../backend/get_borrowed_books.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let html = `
                    <h3 class="mt-4">Libros prestados</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Nombre del usuario</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>`;

                response.data.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.book_title}</td>
                            <td>${row.full_name}</td>
                            <td>${row.phone}</td>
                            <td>
                                <button class="btn btn-warning btn-sm markReturnedBtn" data-id="${row.id}">
                                    Marcar como devuelto
                                </button>
                            </td>
                        </tr>`;
                });

                html += `</tbody></table>`;
                $('#borrowedBooksContainer').html(html);
            } else {
                $('#borrowedBooksContainer').html(`<div class="alert alert-danger">${response.message}</div>`);
            }
        },
        error: function () {
            $('#borrowedBooksContainer').html(`<div class="alert alert-danger">Error al cargar libros prestados</div>`);
        }
    });
}

loadBorrowedBooks();


$(document).on('click', '.markReturnedBtn', function () {
    const reservaId = $(this).data('id');

    $.ajax({
        url: '../backend/mark_returned.php',
        method: 'POST',
        data: { reserva_id: reservaId },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alertify.success(response.message);
                loadBorrowedBooks();
            } else {
                alertify.error(response.message);
            }
        },
        error: function () {
            alertify.error('Error al marcar como devuelto');
        }
    });
});


//////////////////////////////////////////////          CARGA LIBROS PRESTADOS EN PANEL ADMIN / FIN         //////////////////////////////////////////////





//////////////////////////////////////////////          ADMIN USER / INICIO          //////////////////////////////////////////////
///////                                               AÑADIR,EDITAR Y ELIMINAR                                              ///////


function addUser(full_name, email, password, identification_number, phone, fk_role_id) {
    $.ajax({
        url: "../backend/admin_users.php",
        method: "POST",
        data: {
            full_name: full_name,
            email: email,
            password: password,
            identification_number: identification_number,
            phone: phone,
            fk_role_id: fk_role_id
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alertify.success(response.message);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (response.status === "error") {
                alertify.error(response.message);
            } else {
                console.log("Otro error");
                $("#result").html("<p>Error en la llamada AJAX</p>");
            }
        },
        error: function () {
            alertify.error("Ocurrió un error al registrar.");
        }
    });
}


$(document).ready(function () {
    $.ajax({
        url: "../backend/get_users.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var users = response.data;

       
                var usersContainer = $("#usersContainer");
                usersContainer.empty();

                if (users.length > 0) {
           
                    for (var i = 0; i < users.length; i++) {
                        usersContainer.append(`
                            <div class="user-item" id="user-${users[i].user_id}">
                                <div class="user-content">
                                    <span class="user-name">${users[i].full_name}</span>
                                    <span class="user-email">${users[i].email}</span>
                                </div>
                                <div class="user-actions">
                                    <button class="edit_user-btn" data-id="${users[i].user_id}">Editar</button>
                                    <button class="delete_user-btn" data-id="${users[i].user_id}">Eliminar</button>
                                </div>
                            </div>
                        `);

                    }


                    $(".edit_user-btn").click(function () {
                        var userId = $(this).data("id");
                        editUser(userId);
                    });



                    $(".delete_user-btn").click(function () {
                        var userId = $(this).data("id");
                        deleteUser(userId);
                    });


                    $("#editUserForm").submit(function (event) {
                        event.preventDefault();

                        const userId = $("#editUserId").val();
                        const fullName = $("#editFullName").val();
                        const email = $("#editEmail").val();
                        const phone = $("#editPhone").val();

                        $.ajax({
                            url: "../backend/update_user.php",
                            method: "POST",
                            data: {
                                user_id: userId,
                                full_name: fullName,
                                email: email,
                                phone: phone
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.status === "success") {
                                    alertify.success("Usuario actualizado correctamente");
                                    $("#editUserModal").modal("hide");
                                    location.reload();
                                } else {
                                    alertify.error(response.message);
                                }
                            },
                            error: function () {
                                alertify.error("Error al actualizar el usuario.");
                            }
                        });
                    });


                } else {
                    usersContainer.html("<p>No hay usuarios registrados.</p>");
                }
            } else {
                alertify.error("Error al obtener los usuarios.");
            }
        },
        error: function () {
            alertify.error("Error de conexión al servidor.");
        }
    });

    function editUser(userId) {
        $.ajax({
            url: "../backend/get_user_by_id.php",
            method: "POST",
            data: { id: userId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    const user = response.data;
                    $("#editUserId").val(user.user_id);
                    $("#editFullName").val(user.full_name);
                    $("#editEmail").val(user.email);
                    $("#editPhone").val(user.phone);

                    $("#editUserModal").modal("show");
                } else {
                    alertify.error("No se encontró el usuario.");
                }
            },
            error: function () {
                alertify.error("Error al buscar usuario.");
            }
        });
    }


    function deleteUser(id) {
        alertify.confirm("Eliminar usuario", "¿Estás seguro de que quieres eliminar este usuario?", function () {
            $.ajax({
                url: "../backend/delete_users.php",
                method: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status === "success") {
                        alertify.success("Usuario eliminado con éxito.");
                        location.reload();
                    } else {
                        alertify.error(response.message);
                    }
                },
                error: function () {
                    alertify.error("Error al eliminar el usuario.");
                }
            });
        }, function () {
            alertify.error("Eliminación cancelada.");
        });
    }

});


//////////////////////////////////////////////          ADMIN USER / FIN          //////////////////////////////////////////////


document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.querySelector('.sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
});




$(document).ready(function () {

    $.ajax({
        url: "../backend/get_access_data.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var accessData = response.data;

                var dates = accessData.map(item => item.access_date);
                var totals = accessData.map(item => item.total);

                var ctx = document.getElementById("accessChart").getContext("2d");

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Accesos por día',
                            data: totals,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: tooltipItem => tooltipItem.raw + " accesos"
                                }
                            }
                        },
                        scales: {
                            x: { title: { display: true, text: 'Fecha' } },
                            y: { title: { display: true, text: 'Número de accesos' } }
                        }
                    }
                });

                $('#view-1-chart').removeClass('d-none');
            } else {
                alertify.error("Error al obtener los datos de acceso.");
            }
        },
        error: function () {
            alertify.error("Error de conexión al servidor.");
        }
    });



    $.ajax({
        url: "../backend/get_reservations_data.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var reservationData = response.data;

                var dates = reservationData.map(item => item.reservation_date);
                var totals = reservationData.map(item => item.total);

                var ctx = document.getElementById("reservationChart").getContext("2d");

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Reservaciones por día',
                            data: totals,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: tooltipItem => tooltipItem.raw + " reservaciones"
                                }
                            }
                        },
                        scales: {
                            x: { title: { display: true, text: 'Fecha' } },
                            y: { title: { display: true, text: 'Número de reservaciones' } }
                        }
                    }
                });

                $('#view-reservations-chart').removeClass('d-none');
            } else {
                alertify.error("Error al obtener los datos de reservaciones.");
            }
        },
        error: function () {
            alertify.error("Error de conexión al servidor.");
        }
    });



    document.getElementById('mobile-toggle').addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('show');
    });
});
