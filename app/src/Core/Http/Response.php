<?php

declare(strict_types=1);

namespace App\Core\Http;

/**
 * HTTP responses operations
 *
 * @package App\Core\Router
 * @final
 */
final class Response
{
    /**
     * Set a HTTP response status code
     *
     * @param int $responseStatusCode New response status code
     * @return void
     */
    public static function setResponseStatusCode(int $responseStatusCode): void
    {
        http_response_code($responseStatusCode);
    }

    /**
     * Redirect application to another URL
     *
     * @param string $redirectPath URL to redirect app
     * @return void
     */
    public static function setRedirection(string $redirectPath): void
    {
        header('Location: ' . $redirectPath);
        exit();
    }

    /**
     * Set a custom header
     *
     * @param string $header Header string
     * @return void
     */
    public static function setHeader(string $header): void
    {
        header($header);
    }

    /**
     * Send a JSON response
     *
     * @param array $data Data to be sent as JSON
     * @param int $statusCode HTTP status code
     * @return void
     */
    public static function sendJson(array $data, int $statusCode = 200): void
    {
        self::setHeader('Content-Type: application/json');
        self::setResponseStatusCode($statusCode);
        echo json_encode($data);
        exit();
    }
}
