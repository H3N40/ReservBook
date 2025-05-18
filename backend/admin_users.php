<?php
session_start();
require_once './config.php';

class RegisterUser
{
    private $db;

    public function __construct()
    {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function addUser($full_name, $email, $password, $identification_number, $phone, $fk_role_id)
    {
        // Verificar si el correo o número de identificación ya existen
        $checkSql = "SELECT * FROM users WHERE email = :email OR identification_number = :identification_number";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->bindParam(':identification_number', $identification_number);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return 'exists';
        }

        // Insertar el nuevo usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertSql = "INSERT INTO users (full_name, email, password, identification_number, phone, fk_role_id)
                      VALUES (:full_name, :email, :password, :identification_number, :phone, :fk_role_id)";

        try {
            $insertStmt = $this->db->prepare($insertSql);
            $insertStmt->bindParam(':full_name', $full_name);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':password', $hashedPassword);
            $insertStmt->bindParam(':identification_number', $identification_number);
            $insertStmt->bindParam(':phone', $phone);
            $insertStmt->bindParam(':fk_role_id', $fk_role_id);

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
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $identification_number = $_POST['identification_number'];
    $phone = $_POST['phone'];
    $fk_role_id = $_POST['fk_role_id'];

    $register = new RegisterUser();
    $result = $register->addUser($full_name, $email, $password, $identification_number, $phone, $fk_role_id);

    if ($result === 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Usuario registrado exitosamente'
        );
    } elseif ($result === 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'El usuario ya existe (correo o identificación duplicados)'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al registrar el usuario'
        );
    }

    echo json_encode($response);
}
?>
