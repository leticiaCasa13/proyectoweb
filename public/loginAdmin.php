<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../public/api/config/database.php';
require_once __DIR__ . '/../src/controller/AdminController.php';

use controller\AdminController;

// Capturamos el array devuelto por database.php
$config = require __DIR__ . '/../public/api/config/database.php';    // ← misma ruta aquí

// Si ya estás logueado, redirige directamente al dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: /admin/dashboard");
    exit;
}

// Crear el controlador pasando el array $config correctamente
$adminController = new AdminController($config);
$adminController->login();
