<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Mensaje de conexión
echo "¡Conexión establecida!<br>";

// Configuración de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Cambia a true si necesitas caché en producción
]);

// Función para generar URLs de recursos estáticos
$twig->addFunction(new \Twig\TwigFunction('asset', function ($path) {
    // Devuelve la ruta relativa desde la carpeta public
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

