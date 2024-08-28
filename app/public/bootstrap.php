<?php

declare(strict_types=1);

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\Router;
use App\Core\Router\Routes;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Setting up charset
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input();
mb_regex_encoding('UTF-8');

// Setting up secutiry headers
Response::setHeader("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net 'unsafe-inline'; object-src 'none'; frame-ancestors 'self'; base-uri 'self';");
Response::setHeader('Referrer-Policy: no-referrer-when-downgrade');
Response::setHeader('X-Content-Type-Options: nosniff');
Response::setHeader('X-Frame-Options: SAMEORIGIN');

if (!Request::isLocalhost()) {
    Response::setHeader('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    Response::setHeader('Expect-CT: max-age=86400, enforce, report-uri="https://app.com/report-ct"');
}

$phpdotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

$phpdotenv->load();

$router = new Router();
$routes = new Routes($router);
