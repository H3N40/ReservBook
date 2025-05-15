<?php
require_once './config.php';

class GetAccessData {
    private $db;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->db = $dbConfig->getConnection();
    }

    public function getAccesses() {
        $sql = "
            SELECT DATE(entry_date) AS access_date, COUNT(*) AS total
            FROM accesses
            GROUP BY access_date
            ORDER BY access_date ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Validar y procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $access = new GetAccessData();
    $data = $access->getAccesses();

    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parámetro incorrecto']);
}
?>
