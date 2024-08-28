<?php

declare(strict_types=1);

namespace App\Core\Http;

/**
 * Usefull methods for URL manupulation
 *
 * @package App\Core\Http
 */
final class Url
{
    /**
     * Gets application current protocol
     *
     * @return string
     */
    public static function getProtocol(): string
    {
        if (
            isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            return 'https://';
        }

        return 'http://';
    }

    /**
     * Get current source path
     *
     * @param null|string $urlPath Source path
     * @return string
     */
    public static function getUrl(?string $urlPath = null): string
    {
        return self::getProtocol() . $_SERVER['HTTP_HOST'] . $urlPath ?? '';
    }
}
