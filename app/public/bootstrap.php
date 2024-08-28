<?php

declare(strict_types=1);

use App\Core\Router\Router;
use App\Core\Router\Routes;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Setting up charset
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input();
mb_regex_encoding('UTF-8');

$phpdotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

$phpdotenv->load();

$router = new Router();
$routes = new Routes($router);
