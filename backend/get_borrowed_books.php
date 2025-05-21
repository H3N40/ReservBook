<?php
header('Content-Type: application/json');
require_once './config.php';

try {
    $db = new DbConfig();
    $conn = $db->getConnection();

    $sql = "SELECT 
            r.id,
            b.title AS book_title,
            u.full_name,
            u.phone
        FROM 
            reservations r
        JOIN books b ON r.book_id = b.id
        JOIN users u ON r.user_id = u.user_id
        WHERE r.status = 'borrowed'
        ORDER BY r.reserved_at DESC";


    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
