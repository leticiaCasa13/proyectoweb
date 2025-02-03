<?php

// Este archivo devuelve un array con los parámetros de configuración
return [
    'host' => '127.0.0.1', // Dirección del servidor de base de datos
    'port' => '3306',      // Puerto del servidor
    'database' => 'usuarios', // Nombre de la base de datos
    'username' => 'usuario',  // Usuario de la base de datos
    'password' => 'Leticia11-11',  // Contraseña del usuario
    'charset' => 'utf8mb4',                     // Codificación de caracteres
    'collation' => 'utf8mb4_unicode_ci',        // Collation para MySQL

 // Clave secreta para JWT
    'jwt_secret' => 'e69621b72b1c5ff261ed9aee45f6155bd109ed99011c5ac73fe492d6ed3ae08f',  


];