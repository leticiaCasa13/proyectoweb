<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/lang.php';

aplicarIdioma();

// 👇 Mostrar traducciones directamente (para pruebas)
echo "<p><strong>Setlocale actual:</strong> " . setlocale(LC_ALL, 0) . "</p>";
echo "<p><strong>Ruta de gettext:</strong> " . bindtextdomain("messages", realpath(__DIR__ . '/../../locales')) . "</p>";
echo "<p><strong>Traducción test:</strong> " . _("Bienvenido a Germina Luz!") . "</p>";
echo "<p><strong>Otra prueba:</strong> " . _("Hola, mundo") . "</p>";

// 👇 Esto sólo si querés testear en formato JSON con ?json=1
if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "ok",
        "message" => _("Bienvenido a Germina Luz!"),
        "lang" => $_SESSION['lang'] ?? 'es'
    ]);
    exit;
}

?>

<!DOCTYPE html>
<html lang="<?= substr($_SESSION['lang'] ?? 'es', 0, 2) ?>">
<head>
    <meta charset="UTF-8">
    <title><?= _("Bienvenido a Germina Luz!") ?></title>
</head>
<body>
    <h1><?= _("Bienvenido a Germina Luz!") ?></h1>
    <p><?= _("El nombre solo puede contener letras y espacios.") ?></p>
    <p><?= _("El correo electrónico no es válido.") ?></p>
    <p><?= _("El mensaje debe tener al menos 10 caracteres.") ?></p>
    <p><?= _("¡Tu mensaje ha sido enviado con éxito! En breve recibirás respuesta. ¡Gracias por contactarnos!") ?></p>
    <p><?= _("¡Oops! Todos los campos son obligatorios.") ?></p>
    <hr>
    <form>
        <label><?= _("Nombre:") ?></label><br>
        <input type="text" placeholder="<?= _("Nombre:") ?>"><br><br>

        <label><?= _("Correo Electrónico:") ?></label><br>
        <input type="email" placeholder="<?= _("Correo Electrónico:") ?>"><br><br>

        <label><?= _("Mensaje:") ?></label><br>
        <textarea placeholder="<?= _("Mensaje:") ?>"></textarea><br><br>

        <button type="submit"><?= _("Enviar") ?></button>
    </form>

    <hr>
    <h2>Test de traducción exacta (debug)</h2>
    <?php
       $original = "Bienvenido a Germina Luz!";
       $traducido = _("Bienvenido a Germina Luz!");

        if ($original === $traducido) {
          echo "<p style='color: red;'>❌ No se tradujo: '$original'</p>";
        } else {
          echo "<p style='color: green;'>✅ Traducción aplicada: '$traducido'</p>";
        }

        $original = "Bienvenido a Germina Luz!";
        $traducido = _("Bienvenido a Germina Luz!");

        echo "<hr><h3>Debug avanzado</h3>";
        echo "<pre>";
        echo "Original (hex):   " . bin2hex($original) . "\n";
        echo "Traducido (hex):  " . bin2hex($traducido) . "\n";
        echo "</pre>";

    ?>

</body>
</html>
