<?php
require_once __DIR__.'/vendor/autoload.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$requestUri = rtrim($requestUri, '/');

$routes = [
    '' => 'home.php',
];

//echo "<pre>";
//
//echo "</pre>";
//die;

if (array_key_exists($requestUri, $routes)) {
    $page = $routes[$requestUri];
    require __DIR__."/src/{$page}";
} else {
    require __DIR__.'/src/404.php';
}