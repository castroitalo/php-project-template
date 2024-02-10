<?php

declare(strict_types=1);

namespace src\core;

/**
 * Abstract PHP session usage. 
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
     * Start a new user session
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
     * Get a session key value or null if the key session doesn't exists
     *
     * @param string $key
     * @return mixed
     */
    public static function getValue(string $key): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Set a new session value
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
     * Unset a session value. Returns true if the unset was successful or false
     * if it was not
     *
     * @param string $key
     * @return boolean
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
     * check if a session key exists
     *
     * @param string $key
     * @return boolean
     */
    public static function hasKey(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Clear all session value
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
     * Get currento user session as an object
     *
     * @return object
     */
    public static function getSession(): object
    {
        return (object)$_SESSION;
    }

    /**
     * Get current user session id. Return false if there is no session id
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
