<?php
require_once './config.php';

class GetBooks {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getAllBooks() {
        $sql = "SELECT * FROM books";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$getBooks = new GetBooks();
$books = $getBooks->getAllBooks();

echo json_encode(['status' => 'success', 'data' => $books]);
