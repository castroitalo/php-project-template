<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$router->get('/', [stdClass::class, 'someMethod']);
$router->get('/homepage/{id}/{username}', [stdClass::class, 'someMethod']);
$router->post('/', [stdClass::class, 'someMethod'], ['JsonWebTokenMiddleware', 'validateJsonWebToken']);

$router->handleRequest($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
