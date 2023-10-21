<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Class ResponseCore
 * 
 * @package src\core
 */
final class ResponseCore
{
    /**
     * Set a response status code
     *
     * @param integer $responseStatusCode
     * @return void
     */
    public static function setResponseStatusCode(int $responseStatusCode): void 
    {
        http_response_code($responseStatusCode);
    }

    /**
     * Redirect page to another route path
     *
     * @param string $routePath
     * @return void
     */
    public static function redirectTo(string $routePath): void 
    {
        header("Location: " . $routePath);
        exit();
    }
}
