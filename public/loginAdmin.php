<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../public/api/config/database.php';
require_once __DIR__ . '/../src/controller/AdminController.php';

use controller\AdminController;

// Si ya existe sesión de usuario admin, redirigir
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    header("Location: /admin/dashboard");
    exit;
}

$config = require __DIR__ . '/../public/api/config/database.php';
$adminController = new AdminController($config);
$adminController->login();
