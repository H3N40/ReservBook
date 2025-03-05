$(document).ready(function () {
  $("#loginForm").submit(function (event) {
    event.preventDefault();

    var username = $.trim($('input[name="username"]').val());
    var password = $.trim($('input[name="password"]').val());

    password = encodeURIComponent(password);
    loginUser(username, password);
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
        window.location.href = "../views/home.php";
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




