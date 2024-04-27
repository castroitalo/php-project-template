<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use PDOException;

/**
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class DatabaseConnection
{
    /**
     *
     * @var null|PDO
     */
    private static ?PDO $connection = null;

    /**
     *
     */
    private const CONNECTION_SETTINGS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
    ];

    /**
     *
     * @return void
     */
    final public function __construct()
    {
    }

    /**
     *
     * @return void
     */
    final public function __clone(): void
    {
    }

    /**
     *
     * @param null|string $databaseName
     * @return PDO|null|string
     */
    public static function getConnection(?string $databaseName = null): PDO|null|string
    {
        if (is_null(self::$connection)) {
            try {
                $dsnDatabaseName = is_null($databaseName) ? $_ENV['DB_NAME'] : $databaseName;
                $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $dsnDatabaseName . ';dbport=' . $_ENV['DB_PORT'];
                self::$connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DN_PASSWORD'], self::CONNECTION_SETTINGS);
            } catch (PDOException $ex) {
                error_log($ex->getMessage());

                return 'Failed to connect to database...';
            }
        }

        return self::$connection;
    }
}
