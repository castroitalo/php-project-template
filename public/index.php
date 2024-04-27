<?php

use src\controllers\ErrorController;
use src\controllers\HomepageController;
use src\core\App;

require_once __DIR__ . '/bootstrap.php';

ob_start();

try {
    $app = new App();

    $app->router->get('/', [HomepageController::class, 'homepage']);

    // Errors route
    $app->router->get('/page-not-found', [ErrorController::class, 'pageNotFound']);
    $app->router->get('/internal-server-error', [ErrorController::class, 'internalServerError']);

    $app->run();
} catch (Exception $ex) {
    error_log($ex->getMessage());

    echo '<pre>';
    var_dump($ex->getMessage());
    echo '</pre>';
}

ob_end_flush();