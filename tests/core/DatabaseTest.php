<?php 

declare(strict_types=1);

namespace tests\core;

use Dotenv\Dotenv;
use PDO;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\DatabaseCore;

/**
 * Class DatabaseTest
 * 
 * @package tests\core
 */
#[RequiresPhp("8.2.11")]
#[RequiresPhpunit("10.4")]
final class DatabaseTest extends TestCase
{
    /**
     * DatabaseTest setUp
     *
     * @return void
     */
    protected function setUp(): void 
    {
        $dotenv = Dotenv::createImmutable(CONF_ROOT_DIR);

        $dotenv->load();
    }

    /**
     * Test database connection
     *
     * @return void
     */
    public function testDatabaseConnection(): void 
    {
        $connection = DatabaseCore::getDatabaseConnection();

        $this->assertInstanceOf(PDO::class, $connection);
    }

    /**
     * Test if database connection is a singleton connection
     *
     * @return void
     */
    public function testSingletonDatabaseConnection(): void 
    {
        $connectionOne = DatabaseCore::getDatabaseConnection();
        $connectionTwo = DatabaseCore::getDatabaseConnection();

        $this->assertSame($connectionOne, $connectionTwo);
    }
}
