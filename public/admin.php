<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// public/admin.php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controller/AdminController.php'; // ruta correcta

use controller\AdminController;

// Verificación: ¿el administrador está logueado?
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "No estás logueado. Redirigiendo a loginAdmin.php...<br>";  // Depuración
    header("Location: /loginAdmin.php"); // asegúrate que esta ruta existe
    exit;
}


// Crear el controlador
echo "Creando controlador...<br>";  // Depuración
$adminController = new AdminController();

// Router simple basado en URI
$uri = $_SERVER['REQUEST_URI'];
echo "URI: $uri<br>";  // Depuración

if (str_contains($uri, '/admin/plantas')) {
    echo "Acción: listarPlantas<br>";  // Depuración
    $adminController->listarPlantas();
} elseif (str_contains($uri, '/admin/categorias')) {
    echo "Acción: listarCategorias<br>";  // Depuración
    $adminController->listarCategorias();
} elseif (str_contains($uri, '/admin/dashboard')) {
    echo "Acción: dashboard<br>";  // Depuración
    $adminController->dashboard();
} else {
    // Redirigir por defecto al dashboard
    echo "Redirigiendo al dashboard...<br>";  // Depuración
    $adminController->dashboard();
}
