<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use RuntimeException;

/**
 * Application root class
 * 
 * This class boot the application to be used.
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
     * App's database connection
     *
     * @var PDO|null
     */
    public ?PDO $databaseConnection = null;

    /**
     * App's router
     *
     * @var Router|null
     */
    public ?Router $router = null;

    /**
     * Initialize App components
     */
    public function __construct()
    {
        // Starts database connection
        $this->databaseConnection = DatabaseConnection::getDatabaseConnection();

        if (is_null($this->databaseConnection) || is_string($this->databaseConnection)) {
            throw new RuntimeException("Falha na conexão.");
        }

        // Starts router
        $this->router = new Router();

        // Starts user session
        Session::start();
    }

    /**
     * Run application
     *
     * @return void
     */
    public function run(): void
    {
        $this->router->handleRequest(Request::getMethod(), Request::getURI());
    }
}
