<?php

namespace controller;

class ChartDataController {
    public function __construct() {
    
    }

    public function getChartData() {
        require_once __DIR__ . '/../../public/api/config/db_connect.php';

        // Consulta para contar plantas por categoría
        $sql = "
            SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad
            FROM categorias c
            LEFT JOIN plantas p ON c.id = p.categoria_id
            GROUP BY c.id
        ";

        $stmt = $pdo->query($sql);
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        header('Content-Type: application/json');

        

        echo json_encode($resultado);
    }
}
