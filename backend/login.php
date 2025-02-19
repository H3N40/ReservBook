<?php

session_start(); // Asegúrate de iniciar la sesión antes de acceder a las variables de sesión.

require_once './config.php';


class Auth {

  private $db;

  public function __construct(){

     $dbConfig = new DbConfig();
     $this->db = $dbConfig->getConnection();
  }


  public function getDb(){
     return $this->db;
  }


  public function authenticate($username, $password){

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':email', $username);
    $stmt->execute();


    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $hashedPassword = $row['password']; // Obtén la contraseña hasheada almacenada en la base de datos

        if (password_verify($password, $hashedPassword)) {
            // La contraseña proporcionada coincide con la contraseña almacenada

            if ($row['status'] === 'Activo') {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role_id'] = $row['fk_role_id'];
                $_SESSION['nombre'] = $row['full_name'];
                $_SESSION['apellidos'] = $row['last_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['company_id'] = $row['fk_company_id'];
                $_SESSION['fk_departamento_id'] = $row['fk_departamento_id'];




                $status = "Active now";
                $user_id = $row['user_id'];
                $sql2 =  "UPDATE users SET statusChat =  :statusChat  WHERE user_id = :user_id";
                $sql2 = $this->db->prepare($sql2);
                $sql2->bindParam(':statusChat', $status, PDO::PARAM_STR);
                $sql2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $sql2->execute();
                $_SESSION['statusChat'] = $status;



                $compañia =  $row['fk_company_id'];
                

                // Ahora, realiza una consulta para obtener la cantidad total de usuarios
                $sql = "SELECT COUNT(*) AS total_users FROM users WHERE fk_company_id= $compañia";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Agrega el total de usuarios a la sesión
                $_SESSION['total_users'] = $row['total_users'];





                return true; // Autenticación exitosa
            } else {
                return 'inactive'; // Usuario inactivo
            }
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

    $auth = new Auth();
    $result = $auth->authenticate($username, $password);

    if ($result === true) {
        // Autenticación exitosa
        $response = array(
            'status' => 'success',
            'user_id' => $_SESSION['user_id'],
            'role_id' => $_SESSION['role_id'],
            'nombre' => $_SESSION['nombre'],
            'apellidos' => $_SESSION['apellidos'],
            'email' => $_SESSION['email'],
            'total_users' => $_SESSION['total_users']
        );

        
        echo json_encode($response);
    } elseif ($result === 'inactive') {
        // Usuario inactivo
        $response = array(
            'status' => 'error',
            'message' => 'El usuario está inactivo'
        );
        echo json_encode($response);
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
