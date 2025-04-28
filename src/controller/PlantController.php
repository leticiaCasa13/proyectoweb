<?php

namespace controller;

use src\Database;
use PDO;

require_once __DIR__ . '/../Database.php'; // Ruta a tu clase Database


class PlantController
{
    private $twig;
    private $config;

    public function __construct($twig, $config)
    {
        $this->twig = $twig;
        $this->config = $config;
    }

    public function show($id)
    {
        // Obtener la conexión PDO
        $db = Database::getInstance($this->config)->getConnection();

        // Consultar planta por ID
        $stmt = $db->prepare("SELECT * FROM plantas WHERE id = ?");
        $stmt->execute([$id]);
        $planta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$planta) {
            http_response_code(404);
            echo "Planta no encontrada.";
            return;
        }

        echo $this->twig->render('plantaCarrito.html.twig', [
            'planta' => $planta
        ]);
    }
}
