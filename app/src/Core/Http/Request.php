<?php

declare(strict_types=1);

namespace App\Core\Http;

/**
 * HTTP request operations
 *
 * @package App\Core\Router
 * @final
 */
final class Request
{
    /**
     * Get the HTTP request method
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the HTTP request URI
     *
     * @return string
     */
    public function getRequestUri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
