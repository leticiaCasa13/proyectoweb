
<?php

// ACTIVAR ERRORES
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Directorio donde están tus vistas (plantillas o archivos Twig)
$viewDir = __DIR__ . '/../templates/';

// Obtener la solicitud actual y normalizarla
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Divide la solicitud en ruta y parámetros
$request = rtrim(str_replace('/index.php', '', $request), '/'); // Elimina '/index.php' y barras finales

// Función para devolver la ruta correspondiente y los datos
function getRouteData($request) {
    switch ($request) {
        case '':
        case '/':
            return [
                    'controller' => 'HomeController',
                    'method' => 'home',
                    'params' => [],
                    ]; 

        case '/users': // Página de usuarios
            return [
                'template' => 'Users.html.twig',
                'data' => [
                    'title' => 'Usuarios',
                ],
            ];
        
        case '/contact':
            return [
                'controller' => 'ContactController',
                'method' => 'index',
                'params' => [],
            ];
    
            

        case '/plantas': // Lista de plantas medicinales
            return [
                'template' => 'plantas.html.twig',
                'data' => [
                    'title' => 'Plantas Medicinales',
                    'description' => 'Algunas de las familias de plantas medicinales y sus propiedades.',
                    'plantas' => [
                        [
                            'nombre' => 'Caléndula',
                            'imagen' => 'calendula1.png',
                            'description' => 'La caléndula es conocida por sus propiedades antiinflamatorias.',
                        ],
                        [
                            'nombre' => 'Aloe Vera',
                            'imagen' => 'aloe1.png',
                            'description' => 'El aloe vera hidrata y regenera la piel.',
                        ],
                        [
                            'nombre' => 'Lavanda',
                            'imagen' => 'lavanda.png',
                            'description' => 'La lavanda tiene propiedades relajantes y ayuda a reducir el estrés.',
                        ],
                    ],
                ],
            ];

        case '/quienes_somos': // Quiénes somos
            return [
                'template' => 'QuienesSomos.html.twig',
                'data' => [
                    'title' => 'Quiénes Somos',
                    'description' => 'Conoce más sobre nuestra historia, misión y valores.',
                ],
            ];

        case '/login': // Página de login
            return [
                'template' => 'login.html.twig',
                'data' => [
                    'title' => 'Iniciar Sesión',
                ],
            ];

        case '/register': // Página de registro
            return [
                'template' => 'register.html.twig',
                'data' => [
                    'title' => 'Registro de Usuario',
                ],
            ];

        case '/carrito': // Página del carrito
            return [
                'template' => 'carrito.html.twig',
                'data' => [
                    'title' => 'Carrito de Compras',
                    'total' => '€0,00',
                ],
            ];
 

               
    }

  

    // Nueva ruta dinámica para categorías
    if (preg_match('/^\/categoria\/(\d+)$/', $request, $matches)) {
        return [
            'controller' => 'HomeController',
            'method' => 'mostrarCategoria',
            'params' => [$matches[1]],
        ];
    }

    return null; // Si no se encuentra la ruta
}

// Obtener la información de la ruta
$routeData = getRouteData($request);


if ($routeData) {
    if (isset($routeData['template'])) {
        // Cargar Twig
        require_once __DIR__ . '/../vendor/autoload.php';
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
        $twig = new \Twig\Environment($loader);

        // Renderizar la plantilla con los datos
        echo $twig->render($routeData['template'], $routeData['data'] ?? []);
        exit;

    } elseif (isset($routeData['controller'])) {
        require_once __DIR__ . "/../src/controller/{$routeData['controller']}.php";
        $controllerClass = "\\controller\\" . $routeData['controller'];
        $controller = new $controllerClass();
        call_user_func_array([$controller, $routeData['method']], $routeData['params']);
        exit;
    }
}



