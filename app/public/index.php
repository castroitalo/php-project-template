<?php

require_once __DIR__ . '/../vendor/autoload.php';

use src\core\router\Router;

$router = new Router();

$router->get('/', [Router::class, 'get']);
$router->get('/another', [Router::class, 'get']);
$router->head('/another', [Router::class, 'get']);

echo '<pre>';
var_dump($router->getDefinedRoutes());
echo '</pre>';
