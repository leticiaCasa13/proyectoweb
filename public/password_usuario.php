<?php
// Define la contraseña aquí
$password = "password_1234_segura";

// Genera el hash
$hash = password_hash($password, PASSWORD_BCRYPT);

// Muestra el hash
echo "El hash generado para la contraseña es: $hash\n";
?>

