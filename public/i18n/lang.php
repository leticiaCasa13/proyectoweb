<?php
// Inicia la sesión si aún no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar idioma preferido desde la URL, sesión o navegador
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

// Función para aplicar el idioma
function aplicarIdioma() {
    $locale = detectarIdioma(); // 'es_ES' o 'en_US'
    $_SESSION['lang'] = $locale;

    // Locale completo con codificación
    $localeFull = $locale . '.utf8';

    // Establecer locale en el sistema
    putenv("LC_ALL=$localeFull");
    $set = setlocale(LC_ALL, $localeFull);

    // Mostrar resultado del intento
    if (!$set) {
        echo "<p><strong>⚠️ setlocale falló para:</strong> $localeFull</p>";
    } else {
        echo "<p><strong>✅ setlocale aplicado:</strong> $set</p>";
    }

    // Configurar dominio y ruta de traducciones
    $directorioLocales = realpath(__DIR__ . '/../../locales');
    bindtextdomain("messages", $directorioLocales);
    bind_textdomain_codeset("messages", "UTF-8");
    textdomain("messages");

    // 🔍 Diagnóstico (opcional)
    echo "<p><strong>Ruta buscada:</strong> $directorioLocales</p>";
    $moPath = "$directorioLocales/$locale/LC_MESSAGES/messages.mo";
    echo "<p><strong>¿Existe archivo .mo?:</strong> " . (file_exists($moPath) ? 'Sí ✅' : 'No ❌') . "</p>";
    echo "<p><strong>Setlocale actual:</strong> " . setlocale(LC_ALL, 0) . "</p>";
    echo "<p><strong>Idioma en sesión:</strong> " . $_SESSION['lang'] . "</p>";
    echo "<pre>";
    var_dump(gettext("No hay categorías disponibles."));
    echo "</pre>";
}
