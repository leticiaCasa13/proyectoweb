<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// public/admin.php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controller/AdminController.php'; // ruta correcta

use controller\AdminController;

//verifica el admin logeado

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {

    header("Location: /loginAdmin.php");
    exit;
}


// 2) Carga de configuración
$config = require __DIR__ . '/api/config/database.php';

// 3) Creamos el controlador PASÁNDOLE la configuración
$adminController = new AdminController($config);

// 4) Router simple basado en URI
$uri = $_SERVER['REQUEST_URI'];

if (str_contains($uri, '/admin/plantas')) {
    $adminController->listarPlantas();
} elseif (str_contains($uri, '/admin/categorias')) {
    $adminController->listarCategorias();
} else {
    // Por defecto, dashboard
    $adminController->dashboard();
}
