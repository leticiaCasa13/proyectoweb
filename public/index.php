<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/api/config/database.php';

require_once __DIR__ . '/../src/controller/AuthController.php';
require_once __DIR__ . '/i18n/lang.php'; // ???

require_once __DIR__ . '/../src/controller/CartController.php';  // FALTABA ESTA LÍNEA
use controller\CartController;                                    // FALTABA ESTA LÍNEA


aplicarIdioma(); // Cambia el idioma con setlocale()

use controller\AuthController;

$authController = new AuthController($config);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $response = $authController->authenticate($email, $password);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Mensaje de conexión
echo "¡Conexión establecida!<br>";

// Configuración de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Cambia a true si necesitas caché en producción
]);

// Procesar formulario de pago (POST)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/procesar-pago' && $method === 'POST') {
    $cartController = new CartController($twig);
    $cartController->procesarPago();
    exit;
}

// Agregar un filtro de traducción para Twig q se encarga de llamar a gettext
//$twig->addFilter(new \Twig\TwigFilter('trans', function ($string) {
    // Usamos gettext para traducir
    //return gettext($string);
//}));

// Función para generar URLs de recursos estáticos
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) {
    return '/' . ltrim($path, '/');  // Esto asegura que la ruta sea relativa a la carpeta public
}));

// Incluir el enrutador
require_once __DIR__ . '/../src/router.php';

// Obtener la plantilla y los datos desde el enrutador
$routeData = getRouteData($_SERVER['REQUEST_URI']);

// Renderizar la plantilla con Twig
if ($routeData) {
    echo $twig->render($routeData['template'], $routeData['data']);
} else {
    http_response_code(404);
    echo $twig->render('404.html.twig', [
        'title' => 'Página no encontrada',
    ]);
}


