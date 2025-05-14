<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../public/api/config/database.php';
require_once __DIR__ . '/../src/controller/AdminController.php';

use controller\AdminController;


$config = require __DIR__ . '/../public/api/config/database.php';
$adminController = new AdminController($config);


// Mostrar siempre el formulario, aunque haya sesión iniciada
$adminController->login(); // Solo aquí se valida al usuario y se redirige si cumple
