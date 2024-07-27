<?php

declare(strict_types=1);

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\Router;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$phpdotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

$phpdotenv->load();

$router       = new Router();
$httpRequest  = new Request();
$httpResponse = new Response();
