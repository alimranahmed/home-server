<?php
require_once __DIR__.'/vendor/autoload.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = rtrim($requestUri, '/');

$routes = [
    '' => 'home.php',
    '/api/stats' => 'api/stats.php',
    '/api/health' => 'api/health.php',
];

if (array_key_exists($requestUri, $routes)) {
    require __DIR__ . '/src/' . $routes[$requestUri];
} else {
    require __DIR__.'/src/404.php';
}
