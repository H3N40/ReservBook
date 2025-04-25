<?php
require_once './config.php';

class GetUsers {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$getUsers = new GetUsers();
$users = $getUsers->getAllUsers();

echo json_encode(['status' => 'success', 'data' => $users]);
