<?php

declare(strict_types=1);

namespace tests\core;

use Dotenv\Dotenv;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PDO;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\DatabaseConnection;

/**
 * DatabaseConnection test case
 *
 * @package tests\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @access public
 * @final
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("^10.3")]
final class DatabaseConnectionTest extends TestCase
{
    // Get mockery dependency
    use MockeryPHPUnitIntegration;

    /**
     * Starts phpdotenv for test case
     *
     * @return void
     */
    protected function setUp(): void
    {
        $phpdotenv = Dotenv::createImmutable(CONF_GENERAL_ROOT_DIR);

        $phpdotenv->load();
    }

    /**
     * Close Mockery after a test
     *
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Test a successful database connection. When DatabaseConnection::getDatabaseConnection()
     * returns a \PDO object.
     *
     * @return void
     */
    public function testSuccessfulDatabaseConnection(): void
    {
        $actual = DatabaseConnection::getDatabaseConnection();

        $this->assertInstanceOf(PDO::class, $actual);
    }

    /**
     * Test a filed database connection. When DatabaseConnection::getDatabaseConnection()
     * return a string with the message "Failed to connect to database."
     *
     * @return void
     */
    public function testFailedDatabaseConnection(): void
    {
        $databaseConnectionMock = Mockery::mock(DatabaseConnection::class);

        $databaseConnectionMock->shouldReceive("getDatabaseConnection")
            ->andReturn("Failed to connect to database.");

        $actual = $databaseConnectionMock->getDatabaseConnection();
        $expect = "Failed to connect to database.";

        $this->assertEquals($expect, $actual);
    }

    /**
     * Test singleton database connection, when the DatabaseConnection::getDatabaseConnection()
     * do not create a new PDO object if there is one already
     *
     * @return void
     */
    public function testSingletonDatabaseConnection(): void
    {
        $databaseConnectionOne = DatabaseConnection::getDatabaseConnection();
        $databaseConnectionTwo = DatabaseConnection::getDatabaseConnection();

        $this->assertEquals($databaseConnectionOne, $databaseConnectionTwo);
    }
}
