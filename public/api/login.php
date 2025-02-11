<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


header("Content-Type: application/json");

require __DIR__ . "/../../vendor/autoload.php"; // Cargar la librería JWT
$config = require __DIR__ . "/config/database.php"; // ✅ Asegurar que la variable existe

require __DIR__ . "/../../src/controller/AuthController.php"; // Cargar controlador

use controller\AuthController;

$authController = new AuthController($config);

// Leer JSON enviado en la solicitud
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

$response = $authController->authenticate($email, $password);
echo json_encode($response);





