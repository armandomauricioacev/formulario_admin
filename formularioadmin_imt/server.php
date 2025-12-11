<?php

// Router para el servidor embebido de PHP.
// Uso: php -S 0.0.0.0:8000 server.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$publicPath = __DIR__ . '/public';

// Servir archivos estáticos si existen en public/
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Forzar redirección de la raíz al login
if ($uri === '/' || $uri === '') {
    header('Location: /login', true, 302);
    exit;
}

// Fallback al front controller de Laravel
require_once $publicPath . '/index.php';

