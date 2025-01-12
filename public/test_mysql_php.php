<?php
$servername = "localhost"; // o la dirección IP del servidor MySQL
$username = "usuario";     // tu nombre de usuario de MySQL
$password = "password";  // tu contraseña de MySQL
$dbname = "usuarios";     // el nombre de tu base de datos

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
