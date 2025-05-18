<?php
require_once "config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $db = new DbConfig();
    $conn = $db->getConnection();

    $sql = "SELECT id, title, author, publisher, publication_year, stock, cover_image, description FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        echo json_encode(["status" => "success", "data" => $book]);
    } else {
        echo json_encode(["status" => "error", "message" => "Libro no encontrado"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
}
?>
