<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");

// Cargar librerías de Composer
require __DIR__ . '/../../vendor/autoload.php'; 

// Incluir la clase Database
require __DIR__ . '/../../src/Database.php'; // La nueva clase Database

// Incluir el controlador de autenticación
require __DIR__ . '/../../src/controller/AuthController.php'; 

use src\Database; // Importar la clase Database
use controller\AuthController;

// Cargar configuración de la base de datos
$config = require __DIR__ . '/config/database.php'; 

// Crear instancia de la base de datos
$db = Database::getInstance($config);
$conn = $db->getConnection();

$authController = new AuthController($config);

$input = json_decode(file_get_contents("php://input"), true);

// Agregamos depuración
file_put_contents(__DIR__ . "/debug.log", print_r($input, true)); // Guardamos datos en un archivo

// Validar que todos los campos estén presentes
if (!isset($input['username'], $input['email'], $input['password'])) {
    echo json_encode(["message" => "Todos los campos son obligatorios"]);
    http_response_code(400);
    exit; // Detener la ejecución si faltan campos
}

$username = trim($input['username']);
$email = trim($input['email']);
$password = password_hash($input['password'], PASSWORD_BCRYPT);

// Verificar si el usuario ya existe
$stmt = $conn->prepare("SELECT id FROM User WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(["message" => "El correo ya está registrado"]);
    http_response_code(400);
    exit; // Detener la ejecución si el correo ya está registrado
}

// Insertar usuario
$stmt = $conn->prepare("INSERT INTO User (username, email, password) VALUES (?, ?, ?)");
if ($stmt->execute([$username, $email, $password])) {
    echo json_encode(["message" => "Registro exitoso"]);
    http_response_code(201);
    exit; // Detener la ejecución después de un registro exitoso
} else {
    echo json_encode(["message" => "Error al registrar"]);
    http_response_code(500);
    exit; // Detener la ejecución si ocurre un error en la inserción
}

// Ya no es necesario el bloque de "Error desconocido", ya que hemos detenido la ejecución con `exit;` en cada respuesta.



