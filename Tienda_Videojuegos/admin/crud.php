<?php
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'agregar') {
    try {
        $nombre = $_POST['titulo'] ?? ''; // Cambiar 'titulo' a 'nombre'
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $stock = $_POST['cantidad'] ?? 0; // Cambiar 'cantidad' a 'stock'

        $sql = "INSERT INTO videojuegos (nombre, descripcion, precio, stock) 
                VALUES (:nombre, :descripcion, :precio, :stock)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':stock' => $stock
        ]);

        echo json_encode(['success' => true, 'message' => 'Videojuego agregado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al agregar: ' . $e->getMessage()]);
    }
    exit;
}
// Listar videojuegos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'listar') {
    try {
        $sql = "SELECT * FROM videojuegos";
        $stmt = $pdo->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al listar videojuegos: ' . $e->getMessage()]);
    }
    exit;
}

// Agregar videojuego
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'agregar') {
    try {
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $descuento = $_POST['descuento'] ?? 0;
        $id_categoria = $_POST['id_categoria'] ?? 1;
        $activo = $_POST['activo'] ?? 1;
        $stock = $_POST['stock'] ?? 0;

        $sql = "INSERT INTO videojuegos (nombre, descripcion, precio, descuento, id_categoria, activo, stock) 
                VALUES (:nombre, :descripcion, :precio, :descuento, :id_categoria, :activo, :stock)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':descuento' => $descuento,
            ':id_categoria' => $id_categoria,
            ':activo' => $activo,
            ':stock' => $stock
        ]);

        echo json_encode(['success' => true, 'message' => 'Videojuego agregado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al agregar: ' . $e->getMessage()]);
    }
    exit;
}

// Eliminar videojuego
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminar') {
    try {
        $id = $_POST['id'] ?? 0;

        $sql = "DELETE FROM videojuegos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Videojuego eliminado']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al eliminar: ' . $e->getMessage()]);
    }
    exit;
}

// Actualizar videojuego
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'actualizar') {
    try {
        $id = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $descuento = $_POST['descuento'] ?? 0;
        $id_categoria = $_POST['id_categoria'] ?? 1;
        $activo = $_POST['activo'] ?? 1;
        $stock = $_POST['stock'] ?? 0;

        $sql = "UPDATE videojuegos 
                SET nombre = :nombre, descripcion = :descripcion, precio = :precio, 
                    descuento = :descuento, id_categoria = :id_categoria, activo = :activo, stock = :stock 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':descuento' => $descuento,
            ':id_categoria' => $id_categoria,
            ':activo' => $activo,
            ':stock' => $stock
        ]);

        echo json_encode(['success' => true, 'message' => 'Videojuego actualizado']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al actualizar: ' . $e->getMessage()]);
    }
    exit;
}
?>
