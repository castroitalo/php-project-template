<?php

declare(strict_types=1);

use App\Core\Http\Request;

require_once __DIR__ . '/bootstrap.php';

try {
    $routes->defineApplicationRoutes();

    $router->handleRequest(
        Request::getRequestMethod(),
        Request::getRequestUri()
    );
} catch (Exception $ex) {
    // Show exception message only in localhost environment
    if (Request::isLocalhost()) {
        $ex->getMessage();
        exit();
    }

    $router->handleRequest('GET', $_ENV['ROUTE_ERROR_INTERNAL_SERVER_ERROR']);
}
