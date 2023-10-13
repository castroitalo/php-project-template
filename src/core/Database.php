<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use PDOException;

/**
 * Class Database
 * 
 * @package src\core
 */
final class Database
{
    /**
     * Singleton database connection
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * PDO options
     *
     * @var array
     */
    private static array $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    /**
     * DBConnection constructor
     */
    final public function __construct()
    {
    }

    /**
     * DBConnection clone
     *
     * @return void
     */
    final public function __clone(): void
    {
    }

    /**
     * Create a new singleton database connection is there is none and return it
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (is_null(self::$connection)) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"],
                    $_ENV["DB_USER"],
                    $_ENV["DB_PASSWORD"],
                    self::$pdoOptions
                );
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }

        return self::$connection;
    }
}
