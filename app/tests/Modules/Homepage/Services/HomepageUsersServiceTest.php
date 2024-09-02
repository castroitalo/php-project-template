<?php

declare(strict_types=1);

namespace Tests\Modules\Homepage\Services;

use App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes\HandlerExceptionCodesEnum;
use App\Core\Exceptions\Database\HandlerException;
use App\Modules\Homepage\Models\HomepageUsersModel;
use App\Modules\Homepage\Services\HomepageUsersService;
use Dotenv\Dotenv;
use PHPUnit\Framework\InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Test HomepageUsersService class module
 *
 * @package Tests\Modules\Homepage\Services
 */
final class HomepageUsersServiceTest extends TestCase
{
    /**
     * Service mocking model
     *
     * @var null|HomepageUsersModel
     */
    private ?HomepageUsersModel $mockingModel = null;

    /**
     * Service class for testing
     *
     * @var null|HomepageUsersService
     */
    private ?HomepageUsersService $testingService = null;

    /**
     * Initialize test case components
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws NoPreviousThrowableException
     */
    protected function setUp(): void
    {
        $this->mockingModel   = $this->createMock(HomepageUsersModel::class);
        $this->testingService = new HomepageUsersService($this->mockingModel);
        $phpdotenv            = Dotenv::createImmutable(dirname(__DIR__, 4));

        $phpdotenv->load();
    }

    /** @test */
    public function HomepageUsersService_test_listing_users_successfully(): void
    {
        $this->mockingModel->method('getUsers')
            ->willReturn([
                "user_id"           => 1,
                "user_name"         => "Jhon",
                "user_surname"      => "Doe",
                "user_phone_number" => "9999999999999"
            ]);

        $actual = $this->testingService->listAllRegisteredUsers();

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(200, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('success', $actual['response_body']['message']);
        $this->assertArrayHasKey('data', $actual['response_body']);
        $this->assertNotEmpty($actual['response_body']['data']);
    }

    /** @test */
    public function HomepageUsersService_test_listing_users_successfully_empty_users(): void
    {
        $this->mockingModel->method('getUsers')
            ->willReturn([]);

        $actual = $this->testingService->listAllRegisteredUsers();

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(200, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('success', $actual['response_body']['message']);
        $this->assertArrayHasKey('data', $actual['response_body']);
        $this->assertEmpty($actual['response_body']['data']);
    }

    /** @test */
    public function HomepageUsersService_test_listing_users_failed(): void
    {
        $this->mockingModel->method('getUsers')
            ->willThrowException(new HandlerException('Failed listing users.', HandlerExceptionCodesEnum::FailedSelect->value));

        $actual = $this->testingService->listAllRegisteredUsers();

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(500, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('failed_listing_users', $actual['response_body']['message']);
        $this->assertArrayNotHasKey('data', $actual['response_body']);
    }

    /** @test */
    public function HomepageUsersService_test_getting_user_data_by_id_successfully(): void
    {
        $userData                    = new stdClass();
        $userData->user_id           = 1;
        $userData->user_name         = 'Jhon';
        $userData->user_surname      = 'Doe';
        $userData->user_phone_number = '9999999999999';

        $this->mockingModel->method('getUserById')
            ->willReturn($userData);

        $actual = $this->testingService->getRegisteredUserById(['user-id' => '1']);

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(200, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('success', $actual['response_body']['message']);
        $this->assertArrayHasKey('data', $actual['response_body']);
    }

    /** @test */
    public function HomepageUsersService_test_getting_user_data_by_id_failed_bad_parameters(): void
    {
        $actual = $this->testingService->getRegisteredUserById([]);

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(400, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('bad_parameters', $actual['response_body']['message']);
        $this->assertArrayNotHasKey('data', $actual['response_body']);
    }

    /** @test */
    public function HomepageUsersService_test_getting_user_data_by_id_failed(): void
    {
        $this->mockingModel->method('getUserById')
            ->willThrowException(new HandlerException('Failed getting users data by id.', HandlerExceptionCodesEnum::FailedSelect->value));

        $actual = $this->testingService->getRegisteredUserById(['user-id' => '2']);

        $this->assertArrayHasKey('response_http_code', $actual);
        $this->assertEquals(500, $actual['response_http_code']);
        $this->assertArrayHasKey('response_body', $actual);
        $this->assertArrayHasKey('message', $actual['response_body']);
        $this->assertEquals('failed_getting_users', $actual['response_body']['message']);
        $this->assertArrayNotHasKey('data', $actual['response_body']);
    }
}
