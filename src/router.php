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
                    'title' => 'Vivero Verde Luz',
                    'message' => '¡Bienvenido a WebScraping.local!',
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
                ],
            ];

        case '/quienes_somos': // Quienes somos
            return [
                'template' => 'QuienesSomos.html.twig',
                'data' => [
                    'title' => 'Quiénes Somos',
                ],
            ];

        default: // Ruta no encontrada
            return null; // Devuelve null si no coincide con ninguna ruta
    }
}

