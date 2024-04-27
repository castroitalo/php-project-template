<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use RuntimeException;

/**
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class App
{
    /**
     *
     * @var PDO|string|null
     */
    public PDO|string|null $databaseConnection = null;

    /**
     *
     * @var null|Router
     */
    public ?Router $router = null;

    /**
     *
     * @return void
     * @throws RuntimeException
     */
    public function __construct()
    {
        // Check if the protocol used to access the website is HTTPS
        if (is_https() === false) {
            throw new RuntimeException('iWuon does not support HTTP protocol.');
        }

        $this->databaseConnection = DatabaseConnection::getConnection();

        // Check database connection
        if (is_string($this->databaseConnection) || is_null($this->databaseConnection)) {
            throw new RuntimeException('Failed to connect to database.');
        }

        $this->router = new Router();

        // Check router
        if (is_null($this->router)) {
            throw new RuntimeException('Fail building router.');
        }

        // Starts new session
        Session::start();
    }

    /**
     *
     * @return void
     */
    public function run(): void
    {
        $this->router->handleRequest(Request::getMethod(), Request::getPath());
    }
}
