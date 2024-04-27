<?php

declare(strict_types=1);

namespace src\core;

/**
 *
 * @package src\models
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class Request
{
    /**
     *
     * @return string
     */
    public static function getPath(): string
    {

        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     *
     * @return string
     */
    public static function getMethod(): string
    {

        return $_SERVER['REQUEST_METHOD'];
    }
}
