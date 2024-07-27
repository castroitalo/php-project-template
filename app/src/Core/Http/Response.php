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
    public function setResponseStatusCode(int $responseStatusCode): void
    {
        http_response_code($responseStatusCode);
    }

    /**
     * Redirect application to another URL
     *
     * @param string $redirectPath URL to redirect app
     * @return void
     */
    public function setRedirection(string $redirectPath): void
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
    public function setHeader(string $header): void
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
    public function sendJson(array $data, int $statusCode = 200): void
    {
        $this->setHeader('Content-Type: application/json');
        $this->setResponseStatusCode($statusCode);
        echo json_encode($data);
        exit();
    }
}
