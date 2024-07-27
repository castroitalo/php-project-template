<?php

declare(strict_types=1);

use App\Core\Middlewares\HomepageMiddleware;
use App\Modules\Homepage\Controllers\HomepageController;

require_once __DIR__ . '/bootstrap.php';

try {
    $router->get('/', [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);

    $router->handleRequest(
        $httpRequest->getRequestMethod(),
        $httpRequest->getRequestUri()
    );
} catch (Exception) {
    $router->handleRequest('GET', '/internal-server-error');
}
