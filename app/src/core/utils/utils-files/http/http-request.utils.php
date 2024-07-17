<?php

declare(strict_types=1);

/**
 * Get HTTP request URI
 *
 * @return string HTTP request URI
 */
function get_http_request_uri(): string
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

/**
 * Get HTTP requested method
 *
 * @return string Requested HTTP method
 */
function get_http_request_method(): string
{
    return $_SERVER['REQUEST_METHOD'];
}
