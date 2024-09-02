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
    public static function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the HTTP request URI
     *
     * @return string
     */
    public static function getRequestUri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Check if project is running on localhost or not
     *
     * @return bool
     */
    public static function isLocalhost(): bool
    {
        return str_contains($_SERVER['HTTP_HOST'], 'localhost') ||
            str_contains($_SERVER['HTTP_HOST'], '127.0.0.1');
    }

    /**
     * Get query parameters
     *
     * @return array
     */
    public static function getQueryParameters(): array
    {
        $queryParameters = [];

        if (self::getRequestMethod() === 'GET' && !empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $queryParameters[$key] = $value;
            }
        }

        return $queryParameters;
    }
}
