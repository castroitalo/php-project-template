<?php

declare(strict_types=1);

use App\Core\Database\Connection;
use App\Core\Middlewares\HomepageMiddleware;
use App\Modules\Homepage\Controllers\HomepageController;

require_once __DIR__ . '/bootstrap.php';

$connection = Connection::getInstance()->getConnection(
    $_ENV['DATABASE_DEV_NAME'],
    $_ENV['DATABASE_DEV_HOST'],
    '3', // $_ENV['DATABASE_DEV_PORT'],
    $_ENV['DATABASE_DEV_USERNAME'],
    $_ENV['DATABASE_DEV_PASSWORD'],
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE               => PDO::CASE_NATURAL
    ]
);

var_dump($connection);

try {
    $router->get('/', [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);

    $router->handleRequest(
        $httpRequest->getRequestMethod(),
        $httpRequest->getRequestUri()
    );
} catch (Exception) {
    $router->handleRequest('GET', '/internal-server-error');
}
