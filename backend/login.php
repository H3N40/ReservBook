<?php

session_start(); // Asegúrate de iniciar la sesión antes de acceder a las variables de sesión.

require_once './config.php';


class Auth
{

    private $db;

    public function __construct()
    {

        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }


    public function getDb()
    {
        return $this->db;
    }


    public function authenticate($username, $password)
    {

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $username);
        $stmt->execute();


        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $hashedPassword = $row['password']; // Obtén la contraseña hasheada almacenada en la base de datos

            if (password_verify($password, $hashedPassword)) {
                // La contraseña proporcionada coincide con la contraseña almacenada
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['fk_role_id'] = $row['fk_role_id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['identification_number'] = $row['identification_number'];
                $_SESSION['phone'] = $row['phone'];




                print_r($_SESSION);
                



                return true; // Autenticación exitosa
            } else {
                return 'invalid'; // Credenciales inválidas
            }
        } else {
            return 'invalid'; // Usuario no encontrado
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    
    print_r($_POST);



    $auth = new Auth();
    $result = $auth->authenticate($username, $password);

    if ($result === true) {
        // Autenticación exitosa
        $response = array(
            'status' => 'success',
            'user_id' => $_SESSION['user_id'],
            'fk_role_id' => $_SESSION['fk_role_id'],
            'full_name' => $_SESSION['full_name'],
            'email' => $_SESSION['email'],
            'identification_number' => $_SESSION['identification_number'],
            'phone' => $_SESSION['phone'],
            'password' => $_SESSION['password']
        );


    } elseif ($result === 'invalid') {
        // Credenciales inválidas
        $response = array(
            'status' => 'error',
            'message' => 'Verifique la información ingresada'
        );
        echo json_encode($response);
    }
}
?>