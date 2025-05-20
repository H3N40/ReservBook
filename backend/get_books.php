<?php
header('Content-Type: application/json');
require_once './config.php';

class GetBooks {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getAllBooks() {
        try {
            $sql = "SELECT * FROM books";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}

$getBooks = new GetBooks();
$books = $getBooks->getAllBooks();

if (isset($books['error'])) {
    echo json_encode(['status' => 'error', 'message' => $books['message']]);
} else {
    echo json_encode(['status' => 'success', 'data' => $books]);
}
