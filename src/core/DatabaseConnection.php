<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use PDOException;

/**
 * DatabaseConnection connects to a database.
 *
 * DatabaseConnection uses information coming from .env
 * file in project root directory, to connect to a
 * database via PDO using a singleton connection.
 * The getConnection() method return a PDO object if
 * the database connection was established and null if
 * it failed.
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @abstract
 */
abstract class DatabaseConnection
{
    /**
     * Database connection instance
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * PDO connection settings
     */
    private const CONNECTION_SETTINGS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    /**
     * Disabled DatabaseConnection constructor
     */
    public final function __construct()
    {
    }

    /**
     * Disabled DatabaseConnection constructor
     *
     * @return void
     */
    public final function __clone(): void
    {
    }

    /**
     * If there is no connection (is null) try to create one.
     *
     * @return PDO|string
     */
    public static function getDatabaseConnection(): PDO|string
    {
        if (is_null(self::$connection)) {
            try {
                $dsn = "mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_NAME"]};dbport={$_ENV["DB_PORT"]}";

                self::$connection = new PDO($dsn, $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], self::CONNECTION_SETTINGS);
            } catch (PDOException $ex) {
                error_log($ex->getMessage());

                return "Failed to connect to database.";
            }
        }

        return self::$connection;
    }
}
