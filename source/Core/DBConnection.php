<?php

namespace Source\Core;

/**
 * 
 * Class DBConnection
 * @abstract
 * @package Source\Core
 */
abstract class DBConnection
{

    /**
     * 
     * @var array OPTIONS
     */
    private const OPTIONS = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ];

    /**
     * 
     * @var \PDO
     */
    private static \PDO $connection;

    /**
     * DBConnection construct disabled
     */
    final protected function __construct()
    {
        
    }

    /**
     * DBConnection clone disabled
     */
    final protected function __clone()
    {
        
    }

    /**
     * 
     * @return \PDO|null
     */
    public static function getConnection(): ?\PDO
    {
        if (empty(DBConnection::$connection)) {
            try {
                DBConnection::$connection = new \PDO(
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    DBConnection::OPTIONS
                );
            } catch (\PDOException $ex) {
                var_dump($ex);

                return null;
            }
        }

        return DBConnection::$connection;
    }

}
