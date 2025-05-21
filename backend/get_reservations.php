<?php
header('Content-Type: application/json');
require_once './config.php';

class GetReservations
{
    private $db;

    public function __construct()
    {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getAllReservations()
    {
        try {
            $sql = "SELECT 
                        r.id, 
                        r.reserved_at, 
                        b.title AS book_title, 
                        u.full_name AS user_name 
                    FROM 
                        reservations r
                    JOIN books b ON r.book_id = b.id
                    JOIN users u ON r.user_id = u.user_id
                    ORDER BY r.reserved_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

$getReservations = new GetReservations();
echo json_encode($getReservations->getAllReservations());
