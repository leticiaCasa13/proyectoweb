<?php
$password_ingresado = "password_1234_segura";
$hash_en_bd = '$2y$10$AvtPn8cehQoo1El9mZDmoebUwpkpKQDovzCxDKXGoGiCuudFUwewm'; // Copia el hash de la BD

if (password_verify($password_ingresado, $hash_en_bd)) {
    echo "✅ La contraseña es correcta";
} else {
    echo "❌ Credenciales incorrectas";
}
?>
