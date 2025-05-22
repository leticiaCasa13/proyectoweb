<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/api/config/database.php';

require_once __DIR__ . '/../src/controller/AuthController.php'; //autenticación
require_once __DIR__ . '/i18n/lang.php'; // ???

require_once __DIR__ . '/../src/controller/CartController.php';  // carrito
use controller\CartController;                                    

require_once __DIR__ . '/../src/controller/AdminController.php';   //panel Admin



// Si se recibe cambio de idioma por formulario. (header.html.twig)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
    $_SESSION['lang'] = $_POST['language'] === 'en' ? 'en_US' : 'es_ES';
    // Redirigir para evitar reenvío del formulario
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}



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
//echo "¡Conexión establecida!<br>";

use controller\AdminController;


// Configuración de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Cambia a true si necesitas caché en producción
    'debug' => true,  // Solo si quieres habilitar el modo de depuración, puedes eliminar esta línea si no lo necesitas
]);


// EDITAR planta (GET)
if (preg_match('#^/admin/planta/editar/(\d+)$#', $_SERVER['REQUEST_URI'], $m) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $adminController = new AdminController($twig, $config);
    $adminController->formularioEditarPlanta($m[1]);
    exit;
}

// ACTUALIZAR planta (POST)
if (preg_match('#^/admin/planta/actualizar/(\d+)$#', $_SERVER['REQUEST_URI'], $m) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminController = new AdminController($twig, $config);
    $adminController->actualizarPlanta($m[1]);
    exit;
}


// AÑADIR PLANTA (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && preg_match('#^/admin/planta/guardar$#', $_SERVER['REQUEST_URI'])
) {
    $ctrl = new AdminController($twig, $config);
    $ctrl->crearPlanta();
    exit;
}


// 1) Mostrar formulario de “Añadir Planta” (GET)
if (preg_match('#^/admin/planta/nueva$#', $_SERVER['REQUEST_URI']) 
    && $_SERVER['REQUEST_METHOD'] === 'GET') 
{
    $ctrl = new AdminController($twig, $config);
    $ctrl->formularioCrearPlanta(); 
    exit;
}

// 2) Procesar formulario de “Añadir Planta” (POST)
if (preg_match('#^/admin/planta/guardar$#', $_SERVER['REQUEST_URI']) 
    && $_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $ctrl = new AdminController($twig, $config);
    $ctrl->crearPlanta(); 
    exit;
}


// --- Eliminar planta (POST) ---
if (preg_match('#^/admin/planta/eliminar/(\d+)$#', $_SERVER['REQUEST_URI'], $m)
    && $_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $ctrl = new AdminController($twig, $config);
    $ctrl->eliminarPlanta($m[1]);
    exit;
}


// Agregar la función de traducción a Twig
//$twig->addGlobal('lang', $_SESSION['lang']);
//$twig->addFunction(new \Twig\TwigFunction('_', fn($string) => gettext($string),
//['is_safe' => ['html']]));




// Procesar formulario de pago (POST)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/procesar-pago' && $method === 'POST') {
    $cartController = new CartController($twig);
    $cartController->procesarPago();
    exit;
}





// Función para generar URLs de recursos estáticos
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) {
    return '/' . ltrim($path, '/');  // Esto asegura que la ruta sea relativa a la carpeta public
}));


// Incluir el enrutador
require_once __DIR__ . '/../src/router.php';

// Obtener la plantilla y los datos desde el enrutador
$routeData = getRouteData($_SERVER['REQUEST_URI']);



//si solo se renderiza la plantilla
if ($routeData && isset($routeData['template'])) {
    echo $twig->render($routeData['template'], $routeData['data']);
}
