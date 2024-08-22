<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Enums\ExceptionCodes\ConnectionExceptionCodes\ConnectionExceptionCodesEnum;
use App\Core\Exceptions\Database\ConnectionException;
use PDO;
use PDOException;

/**
 * Stablish a singleton database connection
 *
 * @package App\Core\Database
 */
final class Connection
{
    /**
     * Singleton connection instance
     *
     * @var null|Connection
     */
    private static ?Connection $instance = null;

    /**
     * Singleton database connection
     *
     * @var null|PDO
     */
    private ?PDO $connection = null;

    /**
     * Private constructor to prevent instantiation
     *
     * @param int $failedConnection Failed database connection creation exception code
     * @return void
     */
    private function __construct(
        private int $failedConnection = ConnectionExceptionCodesEnum::FailedConnection->value
    ) {}

    /**
     * Prevents cloning the instance
     */
    private function __clone() {}

    /**
     * Get the singleton instance of the Connection
     *
     * @return Connection
     */
    public static function getInstance(): Connection
    {
        if (is_null(self::$instance)) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    /**
     * Get a singleton database connection
     *
     * @param string $databaseName Database name
     * @param string $databaseHost Database host
     * @param string $databasePort Database port
     * @param string $databaseUser Database user
     * @param string $databasePassword Database password
     * @param array $connectionAttributes Database connection attributes
     * @return PDO|null|string
     */
    public function getConnection(
        string $databaseName,
        string $databaseHost,
        string $databasePort,
        string $databaseUser,
        string $databasePassword,
        array  $connectionAttributes
    ): PDO|null|string {
        try {
            if ($this->connection === null) {
                $pdoDsn = "mysql:host={$databaseHost};dbname={$databaseName};port={$databasePort}";
                $this->connection = new PDO($pdoDsn, $databaseUser, $databasePassword, $connectionAttributes);
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());

            throw new ConnectionException('Failed connecting to database.', $this->failedConnection);
        }

        return $this->connection;
    }
}
