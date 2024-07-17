<?php

declare(strict_types=1);

/**
 * Set a HTTP response status code
 *
 * @param int $http_response_status_code HTTP response status code
 * @return void
 */
function set_http_response_status_code(int $http_response_status_code): void
{
    http_response_code($http_response_status_code);
}

/**
 * Redirect app to another URI
 *
 * @param string $uri_to_redirect URI to be redirected
 * @return void
 */
function redirect_to(string $uri_to_redirect): void
{
    header('Location: ' . $uri_to_redirect);
    exit();
}
