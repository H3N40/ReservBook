<?php
session_start();
header('Content-Type: application/json');

require_once './config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

if (!isset($_POST['book_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID del libro no proporcionado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];

try {
    $dbConfig = new DbConfig();
    $conn = $dbConfig->getConnection();

    // Verificar stock del libro
    $stmt = $conn->prepare("SELECT stock FROM books WHERE id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo json_encode(['status' => 'error', 'message' => 'Libro no encontrado']);
        exit;
    }

    if ($book['stock'] <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Stock insuficiente']);
        exit;
    }

    // Insertar reserva
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, book_id, reserved_at) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $book_id]);

    // Actualizar stock
    $stmt = $conn->prepare("UPDATE books SET stock = stock - 1 WHERE id = ?");
    $stmt->execute([$book_id]);

    echo json_encode(['status' => 'success', 'message' => 'Reserva registrada con éxito']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
