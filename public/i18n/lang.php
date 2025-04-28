<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detecta idioma desde ?lang, sesión o navegador
function detectarIdioma(): string {
    if (isset($_GET['lang'])) {
        return $_GET['lang'] === 'en' ? 'en_US' : 'es_ES';
    }

    if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    }

    $idiomaNavegador = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    return $idiomaNavegador === 'en' ? 'en_US' : 'es_ES';
}

function aplicarIdioma() {
    $locale = detectarIdioma(); // es_ES o en_US
    $_SESSION['lang'] = $locale;

    // Codificado con .utf8
    $localeFull = $locale . '.utf8';

    // ✅ Establece el locale y muestra el resultado
    putenv("LC_ALL=$localeFull");
    setlocale(LC_ALL, $localeFull);
    bindtextdomain("messages", __DIR__ . '/../../locales'); // Carga el dominio de traducción
    bind_textdomain_codeset("messages", "UTF-8");
    textdomain("messages"); // Define el dominio de traducción

    // 🔍 Diagnóstico
    $directorioLocalizacion = realpath(__DIR__ . '/../../locales');
    echo "<p><strong>Ruta buscada:</strong> $directorioLocalizacion</p>";
    echo "<p><strong>¿Existe archivo .mo?:</strong> " . 
        (file_exists($directorioLocalizacion . '/es_ES/LC_MESSAGES/messages.mo') ? 'Sí ✅' : 'No ❌') . "</p>";
    echo "<p><strong>Setlocale actual:</strong> " . setlocale(LC_ALL, 0) . "</p>";
    echo "<p><strong>Idioma en sesión:</strong> " . $_SESSION['lang'] . "</p>";
    echo "<pre>";
    var_dump(gettext("No hay categorías disponibles.")); // Imprime la traducción
    echo "</pre>";
}

