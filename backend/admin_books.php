<?php
session_start();
require_once './config.php';

class Register
{
    private $db;

    public function __construct()
    {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function addbooks($title, $author, $publisher, $publication_year, $stock, $cover_image)
    {
        $checkSql = "SELECT * FROM books WHERE title = :title";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':title', $title);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return 'exists';
        }

        $insertSql = "INSERT INTO books (title, author, publisher, publication_year, cover_image, stock) 
                      VALUES (:title, :author, :publisher, :publication_year, :cover_image, :stock)";

        try {
            $insertStmt = $this->db->prepare($insertSql);
            $insertStmt->bindParam(':title', $title);
            $insertStmt->bindParam(':author', $author);
            $insertStmt->bindParam(':publisher', $publisher);
            $insertStmt->bindParam(':publication_year', $publication_year);
            $insertStmt->bindParam(':cover_image', $cover_image);
            $insertStmt->bindParam(':stock', $stock);

            if ($insertStmt->execute()) {
                return 'success';
            } else {
                return 'error';
            }
        } catch (PDOException $e) {
            return 'error';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $cover_image = $_POST['cover_image'];
    $stock = $_POST['stock'];

    $register = new Register();
    $result = $register->addbooks($title, $author, $publisher, $publication_year, $cover_image, $stock);

    if ($result === 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Libro registrado exitosamente'
        );
    } elseif ($result === 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'El libro ya está registrado'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al registrar el libro'
        );
    }

    echo json_encode($response);
}
?>
