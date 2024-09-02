<?php

declare(strict_types=1);

namespace Tests\Core\Database;

use App\Core\Database\Handler;
use App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes\HandlerExceptionCodesEnum;
use App\Core\Exceptions\Database\HandlerException;
use CastroItalo\EchoQuery\Builder;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Text Handler class
 *
 * @package Tests\Core\Database
 */
final class HandlerTest extends TestCase
{
    /**
     * Handler object for testing
     *
     * @var null|Handler
     */
    private ?Handler $hander = null;

    /**
     * Database connection data
     *
     * @var array
     */
    private array $databaseConnectionData = [];

    /**
     * Table for testing
     *
     * @var string
     */
    private string $testingTableName = 'users';

    /**
     * Last insert test register
     *
     * @var int
     */
    private int $lastInsertTestRegister = 0;

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
        $this->hander                                 = new Handler(
            $this->databaseConnectionData['db_name'],
            $this->databaseConnectionData['db_host'],
            $this->databaseConnectionData['db_port'],
            $this->databaseConnectionData['db_usrname'],
            $this->databaseConnectionData['db_passwd'],
            $this->databaseConnectionData['db_settings']
        );
    }

    /** @test */
    public function Handler_test_successfull_get_without_placeholders(): void
    {
        $queryTemplate = (new Builder())->select(
            ['*']
        )
            ->from($this->databaseConnectionData['db_name'] . '.' . $this->testingTableName)
            ->getQuery();
        $result        = $this->hander->get($queryTemplate);

        $this->assertIsArray($result);
        $this->assertIsObject($result[0]);
        $this->assertEquals($result[0]->user_name, 'Jhon');
    }

    /** @test */
    public function Handler_test_successfull_get_with_placeholders(): void
    {
        $queryTemplate = (new Builder())->select(
            ['*']
        )
            ->from($this->databaseConnectionData['db_name'] . '.' . $this->testingTableName)
            ->where('user_id')
            ->equalsTo(':user_id')
            ->getQuery();
        $result        = $this->hander->get($queryTemplate, [1]);

        $this->assertIsArray($result);
        $this->assertIsObject($result[0]);
        $this->assertEquals($result[0]->user_name, 'Jhon');
    }

    /** @test */
    public function Handler_test_failed_get_with_wrong_placeholders_and_values(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('Every query placeholder must have it equivalent value.');
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedSelect->value);

        $queryTemplate = (new Builder())->select(
            ['*']
        )
            ->from($this->databaseConnectionData['db_name'] . '.' . $this->testingTableName)
            ->where('user_id')
            ->equalsTo(':user_id')
            ->getQuery();

        $this->hander->get($queryTemplate, [1, 2]);
    }

    /** @test */
    public function Handler_test_failed_get(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedSelect->value);

        $queryTemplate = (new Builder())->select(
            ['*']
        )
            ->from('wrong_database_table')
            ->where('user_id')
            ->equalsTo(':user_id')
            ->getQuery();

        $this->hander->get($queryTemplate, [1]);
    }

    /** @test */
    public function Handler_test_successfull_insert(): void
    {
        $result = $this->hander->insert(
            $this->databaseConnectionData['db_name'] . '.' . $this->testingTableName,
            ['user_name', 'user_surname', 'user_phone_number'],
            ['a_new_user', 'testing_user', '9999999999999']
        );

        $this->assertIsInt($result);

        $this->lastInsertTestRegister = $result;
    }

    /** @test */
    public function Handler_test_failed_insert_wrong_columns_and_values(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('Every column must have an equivalent value with it.');
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedInsertion->value);
        $this->hander->insert(
            $this->databaseConnectionData['db_name'] . '.' . $this->testingTableName,
            ['user_name', 'user_surname', 'user_phone_number'],
            ['a_new_user', 'testing_user']
        );
    }

    /** @test */
    public function Handler_test_failed_insert(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('Failed inserting data into ' . $this->databaseConnectionData['db_name'] . '.' . $this->testingTableName . ' table.');
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedInsertion->value);
        $this->hander->insert(
            $this->databaseConnectionData['db_name'] . '.' . $this->testingTableName,
            ['non_existent_table', 'user_surname', 'user_phone_number'],
            ['a_new_user', 'testing_user', '9999999999999']
        );
    }

    /** @test */
    public function Handler_test_update_successfull(): void
    {
        $update      = $this->hander->update(
            $this->testingTableName,
            ['user_name' => 'Jhon'],
            'user_id = :user_id',
            'user_id=' . 2
        );
        $query       = (new Builder())->select(['*'])
            ->from($this->databaseConnectionData['db_name'] . '.' . $this->testingTableName)
            ->getQuery();
        $currentData = $this->hander->get($query)[1];
        $update      = $this->hander->update(
            $this->testingTableName,
            ['user_name' => 'new_username'],
            'user_id = :user_id',
            'user_id=' . 2
        );
        $newData     = $this->hander->get($query)[1];

        $this->assertTrue($update);
        $this->assertEquals($newData->user_name, 'new_username');
        $this->assertNotEquals($newData->user_name, $currentData->user_name);
    }

    /** @test */
    public function Handler_test_update_failed(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('Failed updating dont_exists table data.');
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedUpdate->value);
        $this->hander->update(
            'dont_exists',
            ['dont_exists' => 'new_value'],
            'dont_exists = :dont_exists',
            'dont_exists=' . 1
        );
    }

    /** @test */
    public function Handler_test_successfull_delete(): void
    {
        $delete = $this->hander->delete(
            $this->databaseConnectionData['db_name'] . '.' . $this->testingTableName,
            'user_id = :user_id',
            'user_id=' . $this->lastInsertTestRegister
        );

        $this->assertTrue($delete);
    }

    /** @test */
    public function Handler_test_failed_delete(): void
    {
        $this->expectException(HandlerException::class);
        $this->expectExceptionMessage('Failed delete data from dont_exists table.');
        $this->expectExceptionCode(HandlerExceptionCodesEnum::FailedDelete->value);
        $this->hander->delete(
            'dont_exists',
            'dont_exists = :dont_exists',
            'dont_exists=' . $this->lastInsertTestRegister
        );
    }
}
