<?php

namespace src\core;

/**
 * Class DBconnection
 * @abstract
 * @package src\core
 */
class DBConnection
{
    /**
     * Current database connection
     * @var \PDO $connection
     */
    private static \PDO $connection;

    /**
     * Database connection options
     * @var array $connOptions
     */
    private static array $connOptions = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ];

    /**
     * DBConnection constructor
     */
    public final function __construct()
    {
    }

    /**
     * DBConnection clone
     */
    public final function __clone()
    {
    }

    /**
     * Get current database connection
     * @return \PDO
     */
    public static function getConnection(): \PDO
    {
        if (empty(DBConnection::$connection)) {
            try {
                self::$connection = new \PDO(
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME . ";port=" . CONF_DB_PORT,
                    CONF_DB_USER,
                    CONF_DB_PASSWORD,
                    self::$connOptions
                );
            } catch (\PDOException $ex) {
                die("Somethign really bad happened");
            }
        }

        return self::$connection;
    }
}
