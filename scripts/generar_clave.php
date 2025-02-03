<?php
//este archivo genera una clave secreta  para poder firmar los tokens JWT, EN LA  AUTENTICACIÓN DE LA API
// Generar una clave segura de 64 caracteres
$clave_secreta = bin2hex(random_bytes(32));

// Mostrar la clave generada
echo "Tu clave segura es: " . $clave_secreta;
