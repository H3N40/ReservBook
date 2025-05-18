<?php
require_once "config.php";

if (
    isset($_POST['id'], $_POST['title'], $_POST['author'], $_POST['publisher'], 
          $_POST['publication_year'], $_POST['stock'], $_POST['cover_image'], $_POST['description'])
) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $stock = $_POST['stock'];
    $cover_image = $_POST['cover_image'];
    $description = $_POST['description'];

    $db = new DbConfig();
    $conn = $db->getConnection();

    $sql = "UPDATE books SET title = ?, author = ?, publisher = ?, publication_year = ?, stock = ?, cover_image = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$title, $author, $publisher, $publication_year, $stock, $cover_image, $description, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el libro"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}
?>
