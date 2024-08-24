<?php

declare(strict_types=1);

use App\Core\Database\Cache;
use App\Core\Middlewares\HomepageMiddleware;
use App\Modules\Homepage\Controllers\HomepageController;

require_once __DIR__ . '/bootstrap.php';

$cache = Cache::getInstance();

$cache->deleteValue('a_new_key');
var_dump($cache->getValue('a_new_key'));

try {
    $router->get('/', [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);

    $router->handleRequest(
        $httpRequest->getRequestMethod(),
        $httpRequest->getRequestUri()
    );
} catch (Exception) {
    $router->handleRequest('GET', '/internal-server-error');
}
