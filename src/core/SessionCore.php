<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class SessionCore
 *
 * @package src\core
 */
final class SessionCore
{
    /**
     * SessionCore constructor
     */
    public function __construct()
    {
        if (empty(session_id())) {
            session_start();
        }
    }

    /**
     * Get a session value
     *
     * @param string $key
     * @return mixed
     */
    public function getSessionValue(string $key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * Set a new session value 
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setSessionValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset a value from $_SESSION
     *
     * @param string $key
     * @return void
     */
    public function unsetSessionValue(string $key): void 
    {
        unset($_SESSION[$key]);
    }

    /**
     * Check if the session has a key 
     *
     * @param string $key
     * @return bool
     */
    public function hasSessionKey(string $key): bool 
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get session as object
     *
     * @return object
     */
    public function getSession(): object
    {
        return (object)$_SESSION;
    }
    
    /**
     * Get current session id 
     *
     * @return string
     */
    public function getSessionId(): string
    {
        return session_id();
    }
}
