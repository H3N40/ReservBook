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

        password = encodeURIComponent(password);

        registerUser(fullName, email, password, identificationNumber, phone);
    });
});

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
