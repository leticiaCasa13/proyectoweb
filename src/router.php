<?php

// Directorio donde están tus vistas (plantillas o archivos Twig)
$viewDir = __DIR__ . '/../templates/';

// Obtener la solicitud actual y normalizarla
$request = strtok($_SERVER['REQUEST_URI'], '?'); // Divide la solicitud en ruta y parámetros
$request = rtrim(str_replace('/index.php', '', $request), '/'); // Elimina '/index.php' y barras finales

// Función para devolver la ruta correspondiente y los datos
function getRouteData($request) {
    switch ($request) {
        case '': 
        case '/': // Ruta principal (página de inicio)
            return [
                'template' => 'home.html.twig',
                'data' => [
                    'title' => 'Germina Luz',
                ],
            ];

        case '/users': // Página de usuarios
            return [
                'template' => 'Users.html.twig',
                'data' => [
                    'title' => 'Usuarios',
                ],
            ];

        case '/contacto': // Página de contacto
            return [
                'template' => 'contact.html.twig',
                'data' => [
                    'title' => 'Contacto',
                    'description' => 'Contáctanos para más información sobre nuestros servicios.',
                ],
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

        case '/carrito': // Página del carrito
            return [
                'template' => 'carrito.html.twig',
                'data' => [
                    'title' => 'Carrito de Compras',
                    'total' => '€0,00', // Inicialmente vacío
                ],
            ];

        default: // Ruta no encontrada
            return null; // Devuelve null si no coincide con ninguna ruta
    }
}
