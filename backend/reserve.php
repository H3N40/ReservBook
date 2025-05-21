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

    // 🔐 Asegurar que solo tenga una reserva
    $stmt = $conn->prepare("SELECT id FROM reservations WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existingReservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingReservation) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ya has reservado un libro. Devuelve el que tienes y reserva otro libro.'
        ]);
        exit;
    }

    // 📦 Verificar stock
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

    // ✅ Insertar reserva
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, book_id, reserved_at) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $book_id]);

    // ➖ Reducir stock
    $stmt = $conn->prepare("UPDATE books SET stock = stock - 1 WHERE id = ?");
    $stmt->execute([$book_id]);

    echo json_encode(['status' => 'success', 'message' => 'Reserva registrada con éxito']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
