<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class that abstract the client request
 * 
 * @package src\models
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @abstract
 */
abstract class Request
{
    /**
     * Get requested URI
     *
     * @return string
     */
    public static function getURI(): string
    {

        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public static function getMethod(): string
    {

        return $_SERVER["REQUEST_METHOD"];
    }
}
