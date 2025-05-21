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

    // Obtener el ID del libro para devolver stock antes de eliminar
    $stmt = $conn->prepare("SELECT book_id FROM reservations WHERE id = ?");
    $stmt->execute([$reserva_id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        echo json_encode(['status' => 'error', 'message' => 'Reserva no encontrada']);
        exit;
    }

    $book_id = $reserva['book_id'];

    // Eliminar la reserva
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$reserva_id]);

    // Aumentar el stock del libro
    $stmt = $conn->prepare("UPDATE books SET stock = stock + 1 WHERE id = ?");
    $stmt->execute([$book_id]);

    echo json_encode(['status' => 'success', 'message' => 'Reserva eliminada correctamente']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
