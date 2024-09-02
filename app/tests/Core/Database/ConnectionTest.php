<?php

declare(strict_types=1);

namespace Tests\Core\Database;

use App\Core\Database\Connection;
use App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes\ConnectionExceptionCodesEnum;
use App\Core\Exceptions\Database\ConnectionException;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Text Connection class
 *
 * @package Tests\Core\Database
 */
final class ConnectionTest extends TestCase
{
    /**
     * Database connection data
     *
     * @var array
     */
    private array $databaseConnectionData = [];

    /**
     * ConnectionTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->databaseConnectionData['db_name']     = getenv('DATABASE_DEV_NAME');
        $this->databaseConnectionData['db_host']     = getenv('DATABASE_DEV_HOST');
        $this->databaseConnectionData['db_port']     = getenv('DATABASE_DEV_PORT');
        $this->databaseConnectionData['db_usrname']  = getenv('DATABASE_DEV_USERNAME');
        $this->databaseConnectionData['db_passwd']   = getenv('DATABASE_DEV_PASSWORD');
        $this->databaseConnectionData['db_settings'] = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE               => PDO::CASE_NATURAL
        ];
    }

    /** @test */
    public function Connection_test_successfull_connection(): void
    {
        $actual = Connection::getInstance()->getConnection(
            $this->databaseConnectionData['db_name'],
            $this->databaseConnectionData['db_host'],
            $this->databaseConnectionData['db_port'],
            $this->databaseConnectionData['db_usrname'],
            $this->databaseConnectionData['db_passwd'],
            $this->databaseConnectionData['db_settings']
        );

        $this->assertInstanceOf(PDO::class, $actual);
        Connection::getInstance()->closeConnection();
    }

    /** @test */
    public function Connection_test_failed_connection(): void
    {
        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage('Failed connecting to database.');
        $this->expectExceptionCode(ConnectionExceptionCodesEnum::FailedConnection->value);
        Connection::getInstance()->getConnection(
            'dont_exists_db',
            $this->databaseConnectionData['db_host'],
            $this->databaseConnectionData['db_port'],
            $this->databaseConnectionData['db_usrname'],
            $this->databaseConnectionData['db_passwd'],
            $this->databaseConnectionData['db_settings']
        );
    }

    /** @test */
    public function Connection_test_successfull_singleton_connection(): void
    {
        $actualOne = Connection::getInstance()->getConnection(
            $this->databaseConnectionData['db_name'],
            $this->databaseConnectionData['db_host'],
            $this->databaseConnectionData['db_port'],
            $this->databaseConnectionData['db_usrname'],
            $this->databaseConnectionData['db_passwd'],
            $this->databaseConnectionData['db_settings']
        );
        $actualTwo = Connection::getInstance()->getConnection(
            $this->databaseConnectionData['db_name'],
            $this->databaseConnectionData['db_host'],
            $this->databaseConnectionData['db_port'],
            $this->databaseConnectionData['db_usrname'],
            $this->databaseConnectionData['db_passwd'],
            $this->databaseConnectionData['db_settings']
        );

        $this->assertEquals($actualOne, $actualTwo);
        Connection::getInstance()->closeConnection();
    }
}
