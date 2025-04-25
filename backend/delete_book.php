<?php

session_start(); // Asegúrate de iniciar la sesión antes de acceder a las variables de sesión.

require_once './config.php';

class Book {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getDb() {
        return $this->db;
    }

    public function deleteBook($id) {

        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $sql = "DELETE FROM books WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'not_found';
        }
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $bookId = $_POST['id'];

    $book = new Book();
    $result = $book->deleteBook($bookId);

    if ($result === 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Libro eliminado con éxito.'
        );
        echo json_encode($response);
    } elseif ($result === 'not_found') {
        $response = array(
            'status' => 'error',
            'message' => 'El libro no fue encontrado.'
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al eliminar el libro.'
        );
        echo json_encode($response);
    }

}

?>
