<?php

declare(strict_types=1);

namespace App\Core\Bases;

use App\Core\Database\Connection;
use PDO;

/**
 * Contains base migration components and operations
 *
 * @package App\Core\Bases
 */
class BaseMigration
{
    /**
     * Database connection
     *
     * @var null|PDO
     */
    protected ?PDO $databaseConnection = null;

    /**
     * Initialize middleware components
     *
     * @return void
     * @throws ConnectionException
     */
    public function __construct()
    {
        $this->databaseConnection = Connection::getInstance()->getConnection(
            $_ENV['DATABASE_DEV_NAME'],
            $_ENV['DATABASE_DEV_HOST'],
            $_ENV['DATABASE_DEV_PORT'],
            $_ENV['DATABASE_DEV_USERNAME'],
            $_ENV['DATABASE_DEV_PASSWORD'],
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_CASE               => PDO::CASE_NATURAL
            ]
        );
    }
}
