<?php

session_start(); // Asegúrate de iniciar la sesión antes de acceder a las variables de sesión.

require_once './config.php';

class User {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getDb() {
        return $this->db;
    }

    public function deleteUser($id) {
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            
            $sql = "DELETE FROM users WHERE user_id = :id";
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
    $userId = $_POST['id'];

    $user = new User();
    $result = $user->deleteUser($userId);

    if ($result === 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Usuario eliminado con éxito.'
        );
        echo json_encode($response);
    } elseif ($result === 'not_found') {
        $response = array(
            'status' => 'error',
            'message' => 'El usuario no fue encontrado.'
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al eliminar el usuario.'
        );
        echo json_encode($response);
    }
}
?>
