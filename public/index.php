<?php

declare(strict_types=1);

use src\controllers\HomeController;
use src\core\App;
use src\core\Response;

// Imports bootstrap file
require_once __DIR__ . "/bootstrap.php";

try {
    $app = new App();

    $app->router->get("/", [HomeController::class, "homepage"]);

    $app->run();
} catch (Exception $ex) {
    Response::setResponseStatusCode(500);
    echo "<h1>App is out of service.</h1>";
}
