<?php
require_once "config.php";

if (isset($_POST['user_id'], $_POST['full_name'], $_POST['email'], $_POST['phone'])) {
    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $db = new DbConfig();
    $conn = $db->getConnection();

    $sql = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$full_name, $email, $phone, $user_id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el usuario"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}
?>
