<?php
require_once "config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $db = new DbConfig();
    $conn = $db->getConnection();

    $sql = "SELECT user_id, full_name, email, phone FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(["status" => "success", "data" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
}
?>
