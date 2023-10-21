<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Class RequestCore
 * 
 * @package src\core
 */
final class RequestCore
{
    /**
     * Get route requested URI
     *
     * @return string
     */
    public static function getRouteUri(): string 
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Get HTTP request method
     *
     * @return string
     */
    public static function getHttpMethod(): string 
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public static function getRequestBody(): array 
    {
        // Request body
        $body = [];

        // Get GET HTTP method body (query string)
        if (self::getHttpMethod() === "GET") {
            if (sizeof($_GET) !== 0) {
                foreach ($_GET as $key => $value) {
                    $body[$key] = $value;
                }
            }
        }

        // Get POST HTTP method body (headers)
        if (self::getHttpMethod() === "POST") {
            if (sizeof($_POST) !== 0) {
                foreach ($_POST as $key => $value) {
                    $body[$key] = $value;
                }
            }
        }

        return $body;
    }
}
