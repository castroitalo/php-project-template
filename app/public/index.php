<?php

declare(strict_types=1);

use App\Core\Middlewares\HomepageMiddleware;
use App\Modules\Homepage\Controllers\HomepageController;

require_once __DIR__ . '/bootstrap.php';

$router->get('/', [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);

$router->handleRequest($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
