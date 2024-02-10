<?php

declare(strict_types=1);

namespace tests\models;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use src\models\Route;
use stdClass;

/**
 * Route test case
 * 
 * @package tests\models
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @access public
 * @final
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("^10.3")]
final class RouteTest extends TestCase
{
    /**
     * Route successful constructor method test data provider
     *
     * @return array
     */
    public static function routeSuccessfulConstructorTestDataProvider(): array
    {
        return [
            "get_method_default_middleware" => ["GET", null],
            "get_method_custom_middleware" => ["GET", [stdClass::class, "method"]],
            "head_method_default_middleware" => ["HEAD", null],
            "head_method_custom_middleware" => ["HEAD", [stdClass::class, "method"]],
            "post_method_default_middleware" => ["POST", null],
            "post_method_custom_middleware" => ["POST", [stdClass::class, "method"]],
            "put_method_default_middleware" => ["PUT", null],
            "put_method_custom_middleware" => ["PUT", [stdClass::class, "method"]],
            "delete_method_default_middleware" => ["DELETE", null],
            "delete_method_custom_middleware" => ["DELETE", [stdClass::class, "method"]],
            "connect_method_default_middleware" => ["CONNECT", null],
            "connect_method_custom_middleware" => ["CONNECT", [stdClass::class, "method"]],
            "options_method_default_middleware" => ["OPTIONS", null],
            "options_method_custom_middleware" => ["OPTIONS", [stdClass::class, "method"]],
            "trace_method_default_middleware" => ["TRACE", null],
            "trace_method_custom_middleware" => ["TRACE", [stdClass::class, "method"]],
            "patch_method_default_middleware" => ["PATCH", null],
            "patch_method_custom_middleware" => ["PATCH", [stdClass::class, "method"]]
        ];
    }

    /**
     * Route successful constructor method test 
     *
     * @return void
     */
    #[DataProvider("routeSuccessfulConstructorTestDataProvider")]
    public function testRouteSuccessfulConstructor(
        string $httpMethod,
        ?array $middlewareCallback
    ): void {
        $path = "/path";
        $controllerCallback = [stdClass::class, "method"];
        $actual = new Route($httpMethod, $path, $controllerCallback, $middlewareCallback);

        $this->assertEquals($httpMethod, $actual->getHttpMethod());
        $this->assertEquals($path, $actual->getPath());
        $this->assertEquals($controllerCallback, $actual->getControllerCallback());
        $this->assertEquals($middlewareCallback, $actual->getMiddlewareCallback());
    }

    /**
     * Route failed constructor method test data provider
     *
     * @return array
     */
    public static function routeFailedConstructorTestDataProvider(): array
    {
        return [
            "invalid_http_method_default_middleware" => [
                "INVALID",
                "/path",
                [stdClass::class, "method"],
                null,
                "Route HTTP method can only be one of these: GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH"
            ],
            "invalid_http_method_custom_middleware" => [
                "INVALID",
                "/path",
                [stdClass::class, "method"],
                [stdClass::class, "method"],
                "Route HTTP method can only be one of these: GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH"
            ],
            "invalid_path_default_middleware" => [
                "GET",
                "",
                [stdClass::class, "method"],
                null,
                "Route path can't be empty."
            ],
            "invalid_path_default_middleware" => [
                "GET",
                "",
                [stdClass::class, "method"],
                null,
                "Route path can't be empty."
            ],
            "invalid_path_custom_middleware" => [
                "GET",
                "",
                [stdClass::class, "method"],
                [stdClass::class, "method"],
                "Route path can't be empty."
            ],
            "invalid_controller_callback_default_middleware" => [
                "GET",
                "/path",
                [],
                null,
                "Route controller callback can't be an empty array."
            ],
            "invalid_controller_callback_custom_middleware" => [
                "GET",
                "/path",
                [],
                [stdClass::class, "method"],
                "Route controller callback can't be an empty array."
            ],
            "invalid_middleware_callback" => [
                "GET",
                "/path",
                [stdClass::class, "method"],
                [],
                "Route middleware callback can't be an empty array."
            ]
        ];
    }

    /**
     * Route failed constructor method test
     *
     * @return void
     */
    #[DataProvider("routeFailedConstructorTestDataProvider")]
    public function testRouteFailedConstructor(
        string $httpMethod,
        string $path,
        array $controllerCallback,
        ?array $middlewareCallback,
        string $expectionMessage
    ): void {
        $this->expectException(RuntimeException::class);

        new Route($httpMethod, $path, $controllerCallback, $middlewareCallback);

        $this->expectExceptionMessage($expectionMessage);
    }
}
