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

    public function registerUser($fullName, $email, $password, $identificationNumber, $phone)
    {

        $checkSql = "SELECT * FROM users WHERE email = :email";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return 'exists';
        }


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $insertSql = "INSERT INTO users (full_name, email, password, identification_number, phone, fk_role_id, status) 
                      VALUES (:full_name, :email, :password, :identification_number, :phone, 2, 'active')";

        try {
            $insertStmt = $this->db->prepare($insertSql);
            $insertStmt->bindParam(':full_name', $fullName);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':password', $hashedPassword);
            $insertStmt->bindParam(':identification_number', $identificationNumber);
            $insertStmt->bindParam(':phone', $phone);

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
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $identificationNumber = $_POST['identification_number'];
    $phone = $_POST['phone'];

    $register = new Register();
    $result = $register->registerUser($fullName, $email, $password, $identificationNumber, $phone);

    if ($result === 'success') {
        $response = array(
            'status' => 'success',
            'message' => 'Registro exitoso'
        );
        echo json_encode($response);
    } elseif ($result === 'exists') {
        $response = array(
            'status' => 'error',
            'message' => 'El correo electrónico ya está registrado'
        );
        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error al registrar el usuario'
        );
        echo json_encode($response);
    }
}
?>