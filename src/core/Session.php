<?php

declare(strict_types=1);

namespace src\core;

/**
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
abstract class Session
{
    /**
     *
     * @return void
     */
    public static function start(): void
    {
        if (empty(session_id())) {
            session_start();
        }
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public static function getValue(string $key): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function setValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public static function unsetValue(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     *
     * @return void
     */
    public static function clear(): void
    {
        foreach ($_SESSION as $key => $value) {
            self::unsetValue($key);
        }

        session_regenerate_id();
    }

    /**
     *
     * @return object
     */
    public static function getSession(): object
    {
        return (object)$_SESSION;
    }

    /**
     *
     * @return string|false
     */
    public static function getId(): string|false
    {
        if (empty(session_id())) {
            return false;
        }

        return session_id();
    }
}
