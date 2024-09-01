<?php

$routes = [
  '/' => './public/views/index.php',
  '/admin' => './public/views/admin.php',
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (isset($routes[$uri])) {
  require $routes[$uri];
} else {
  require '404.php';
}

