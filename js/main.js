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
});

function loginUser(username, password) {
    $.ajax({
        url: "../backend/login.php",
        method: "POST",
        data: {username: username, password: password},
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
                    location.reload(); // Recarga la página
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

                // Contenedor para los libros
                var booksContainer = $("#booksContainer");
                booksContainer.empty();

                if (books.length > 0) {
                    // Recorrer los libros para crear la tabla de ese tamaño
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

                    // boton de editar libros segun su id
                    $(".edit_book-btn").click(function () {
                        var bookId = $(this).data("id");
                        editBook(bookId);
                    });

                    // boton de eliminar libros segun su id
                    $(".delete_book-btn").click(function () {
                        var bookId = $(this).data("id");
                        deleteBook(bookId);
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

    function editBook(id) {


    }

    function deleteBook(id) {
        console.log(id);
        alertify.confirm("Eliminar libro", "¿Estás seguro de que quieres eliminar este libro?", function () {
            $.ajax({
                url: "../backend/delete_book.php",
                method: "POST",
                data: {id: id},
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


});


$(document).ready(function () {
    $.ajax({
        url: "../backend/get_users.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var users = response.data;

                // Contenedor para los usuarios
                var usersContainer = $("#usersContainer");
                usersContainer.empty();

                if (users.length > 0) {
                    // Recorrer los usuarios para crear la tabla de ese tamaño
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

                    // Botón de editar usuario según su id
                    $(".edit_user-btn").click(function () {
                        var userId = $(this).data("id");
                        editUser(userId);
                    });


                    // Botón de eliminar usuario según su id
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
            url: "../backend/get_user_by_id.php", // Nuevo backend que te mostraré abajo
            method: "POST",
            data: {id: userId},
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    const user = response.data;
                    $("#editUserId").val(user.user_id);
                    $("#editFullName").val(user.full_name);
                    $("#editEmail").val(user.email);
                    $("#editPhone").val(user.phone);

                    $("#editUserModal").modal("show"); // Mostrar modal
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
                data: {id: id},
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


document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.querySelector('.sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const views = document.querySelectorAll(".view-section");
    const nextButton = document.getElementById("next-view");
    let currentIndex = 0;

    if (nextButton && views.length > 0) {
        nextButton.addEventListener("click", function () {
            // Ocultar la vista actual
            views[currentIndex].classList.add("d-none");

            // Calcular el siguiente índice
            currentIndex = (currentIndex + 1) % views.length;

            // Mostrar la nueva vista
            views[currentIndex].classList.remove("d-none");
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

                // Mapear fechas y accesos
                var dates = accessData.map(function (item) {
                    return item.access_date;
                });
                var totals = accessData.map(function (item) {
                    return item.total;
                });

                // Seleccionar el contexto del canvas
                var ctx = document.getElementById("accessChart").getContext("2d");

                // Crear el gráfico
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates, // Fechas en el eje X
                        datasets: [{
                            label: 'Accesos por día',
                            data: totals, // Totales de accesos en el eje Y
                            borderColor: 'rgba(75, 192, 192, 1)', // Color de la línea
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color de fondo
                            fill: true, // Rellenar el área bajo la línea
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top', // Ubicación de la leyenda
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.raw + " accesos"; // Mostrar accesos en el tooltip
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Fecha' // Título del eje X
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Número de accesos' // Título del eje Y
                                }
                            }
                        }
                    }
                });

                // Mostrar el gráfico después de cargar los datos
                $('#view-1-chart').removeClass('d-none');
            } else {
                alertify.error("Error al obtener los datos de acceso.");
            }
        },
        error: function () {
            alertify.error("Error de conexión al servidor.");
        }
    });

    // Controlar la visibilidad de las vistas con el botón
    $("#next-view").click(function () {
        $("#view-1").removeClass('d-none');
        $("#view-1").addClass('d-none');
    });
});

