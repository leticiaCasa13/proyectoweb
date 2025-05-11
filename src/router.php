<?php

// ACTIVAR ERRORES
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Cargar configuración de base de datos
require_once __DIR__ . '/../public/api/config/database.php';
$config = require __DIR__ . '/../public/api/config/database.php';

require_once __DIR__ . '/../src/controller/CartController.php';



// Iniciar Twig
require_once __DIR__ . '/../vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);

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

        case '/users':
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
                'data' => [
                'title' => 'Contacto',
                'description' => 'Contacta con nosotros'
                    ]
                ];
            

        case '/plantas':
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

        case '/quienes_somos':
            return [
                'template' => 'QuienesSomos.html.twig',
                'data' => [
                    'title' => 'Quiénes Somos',
                    'description' => 'Conoce más sobre nuestra historia, misión y valores.',
                ],
            ];

        case '/login':
            return [
                'template' => 'login.html.twig',
                'data' => [
                    'title' => 'Iniciar Sesión',
                ],
            ];

        case '/register':
            return [
                'template' => 'register.html.twig',
                'data' => [
                    'title' => 'Registro de Usuario',
                ],
            ];

        case '/carrito':
            return [
                'controller' => 'CartController',
                'method' => 'mostrarCarrito',
                'params' => [],
            ];

        case '/checkout':
            return [
                'controller' => 'CartController',
                'method' => 'verCheckout',
                'params' => [],
                ];

         
         case '/grafico-categorias':
            return [
                    'controller' => 'GraficoController',
                    'method' => 'mostrarGrafico',
                    'params' => [],
                ];
                

        case '/chart-data':
            return [
                    'controller' => 'ChartDataController',
                    'method' => 'getChartData',
                    'params' => [],
                ];
                
                       
               
        case '/finalizar-compra':
            return [
                'template' => 'pago.html.twig',
                'data' => [
                        'title' => 'Finalizar Compra',
                    ],
            ];
                   
            

        case '/planta-carrito':
            return [
                'template' => 'plantaCarrito.html.twig',
                'data' => [
                    'title' => 'Detalle de Planta',
                ],
            ];

        case '/carrito/agregar':
            return [
                'controller' => 'CartController',
                'method' => 'agregar',
                'params' => [],
            ]; 
            
            
        case '/planta':      //permite acceder a una planta individual(carrito)
            if (isset($_GET['id'])) {
            return [
                'controller' => 'CartController',
                'method' => 'verPlanta',
                'params' => [$_GET['id']],
                ];
            }
            break;


        case '/buscar':
            return [
                    'controller' => 'HomeController',
                    'method' => 'buscarPlantas',
                    'params' => [],
            ];

        case '/procesar-pago':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo $twig->render('confirmacion.html.twig');
                exit;
            }
            break;
               
        case '/admin/dashboard':
            return [
                'template' => 'admin/dashboard.html.twig',
                'data' => [],
            ];

        case '/loginAdmin':
            return [
                'controller' => 'AdminController',
                'method' => 'login',
                'params' => [],
            ];


        
                
    }



    // Ruta dinámica para categoría
    if (preg_match('/^\/categoria\/(\d+)$/', $request, $matches)) {
        return [
            'controller' => 'HomeController',
            'method' => 'mostrarCategoria',
            'params' => [$matches[1]],
        ];
    }

    // Ruta dinámica para planta
    if (preg_match('/^\/planta\/(\d+)$/', $request, $matches)) {
        return [
            'controller' => 'PlantController',
            'method' => 'show',
            'params' => [$matches[1]],
        ];
    }


    // Cambiar idioma según la selección del usuario
     if (isset($_POST['language'])) {
    $_SESSION['lang'] = $_POST['language'] === 'en' ? 'en_US' : 'es_ES';
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige para aplicar el cambio de idioma
}




    return null;
}



// Obtener la información de la ruta
$routeData = getRouteData($request);

if ($routeData) {
    if (isset($routeData['template'])) {
        echo $twig->render($routeData['template'], $routeData['data'] ?? []);
        exit;

    } elseif (isset($routeData['controller'])) {
        require_once __DIR__ . "/controller/{$routeData['controller']}.php";
        $controllerClass = "\\controller\\" . $routeData['controller'];
        $controller = new $controllerClass($twig, $config); // ✅ Pasamos $twig al constructor
        call_user_func_array([$controller, $routeData['method']], $routeData['params']);
        exit;
    }
}
// Si no se encuentra la ruta
http_response_code(404);
echo $twig->render('404.html.twig', ['title' => 'Página no encontrada']);



