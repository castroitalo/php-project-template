<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$router->get('/', [stdClass::class, 'someMethod']);

echo '<pre>';
var_dump($router->getDefinedRoutes());
echo '</pre>';
