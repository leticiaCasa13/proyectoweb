<?php

// Este archivo devuelve un array con los parámetros de configuración
return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1', // Dirección del servidor de base de datos
    'port' => getenv('DB_PORT') ?: '3306',      // Puerto del servidor
    'database' => getenv('DB_NAME') ?: 'usuarios', // Nombre de la base de datos
    'username' => getenv('DB_USER') ?: 'usuario',  // Usuario de la base de datos
    'password' => getenv('DB_PASSWORD') ?: 'password',  // Contraseña del usuario
    'charset' => 'utf8mb4',                     // Codificación de caracteres
    'collation' => 'utf8mb4_unicode_ci',        // Collation para MySQL
];
