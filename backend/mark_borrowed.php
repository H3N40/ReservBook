<?php
header('Content-Type: application/json');
require_once './config.php';

if (!isset($_POST['reserva_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID de reserva no proporcionado']);
    exit;
}

$reserva_id = $_POST['reserva_id'];

try {
    $db = new DbConfig();
    $conn = $db->getConnection();

    // Actualizar estado a 'borrowed'
    $stmt = $conn->prepare("UPDATE reservations SET status = 'borrowed' WHERE id = ?");
    $stmt->execute([$reserva_id]);

    echo json_encode(['status' => 'success', 'message' => 'Reserva marcada como prestada']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
