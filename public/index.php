<?php

use src\controllers\HomeController;
use src\controllers\NotFoundController;
use src\core\RouterCore;

require_once __DIR__ . "/bootstrap.php";

$router = new RouterCore();

$router->get("/", [HomeController::class, "homepage"]);

$router->get("/notfound", [NotFoundController::class, "notFoundPage"]);

$router->handleRequest();
