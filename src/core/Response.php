<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class that abstract the server response
 * 
 * @package src\models
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0 
 * @access public
 * @abstract
 */
abstract class Response
{
    /**
     * @param int $statusCode
     * @return void
     */
    public static function setResponseStatusCode(int $statusCode): void
    {

        http_response_code($statusCode);
    }

    /**
     * @param string $path
     * @return void
     */
    public static function redirectTo(string $path): void
    {

        header("Location: " . $path);
        exit();
    }
}
