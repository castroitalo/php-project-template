<?php

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\RouterCore;
use stdClass;

/**
 * Class RouterTest 
 * 
 * @package tests\core
 */
#[RequiresPhp("8.2.11")]
#[RequiresPhpunit("10.4")]
final class RouterTest extends TestCase
{
    /**
     * Router object for testing
     *
     * @var Router
     */
    private RouterCore $router;

    /**
     * RouterTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new RouterCore();
    }

    /**
     * Test Router::get
     *
     * @return void
     */
    public function testAddGetMethodRouteToRoutesList(): void
    {
        $this->router->get("/", [stdClass::class, "method"]);

        $getRoutes = $this->router->getRoutes()["GET"];

        $this->assertArrayHasKey("/", $getRoutes);
    }

    /**
     * Test Router::post
     *
     * @return void
     */
    public function testAddPostMethodRouteToRoutesList(): void
    {
        $this->router->post("/", [stdClass::class, "method"]);

        $postRoutes = $this->router->getRoutes()["POST"];

        $this->assertArrayHasKey("/", $postRoutes);
    }

    /**
     * Router::matchFixedUri test data provider
     *
     * @return array
     */
    public static function matchFixedUriTestDataProvider(): array
    {
        return [
            "successfully_without_middleware" => [
                "GET",
                "/",
                [stdClass::class, "method"],
                false,
                [
                    "controller" => [stdClass::class, "method"],
                    "middleware" => false
                ]
            ],
            "successfully_with_middleware" => [
                "GET",
                "/",
                [stdClass::class, "method"],
                [stdClass::class, "method"],
                [
                    "controller" => [stdClass::class, "method"],
                    "middleware" => [stdClass::class, "method"]
                ]
            ],
            "failed_without_middleware" => [
                "GET",
                "/failed",
                [stdClass::class, "method"],
                false,
                false
            ],
            "failed_with_middleware" => [
                "GET",
                "/failed",
                [stdClass::class, "method"],
                [stdClass::class, "method"],
                false
            ]
        ];
    }

    /**
     * Test Router::matchFixedUri
     *
     * @param string $httpMethod
     * @param string $routeUri
     * @param array|false $expect
     * @return void
     */
    #[DataProvider("matchFixedUriTestDataProvider")]
    public function testMatchFixedUri(
        string $httpMethod,
        string $routeUri,
        array $routeController,
        array|false $routeMiddleware,
        array|false $expect
    ): void {
        $this->router->get("/", $routeController, $routeMiddleware);

        if ($expect === false) {
            $this->assertFalse($this->router->matchFixedUri(
                $httpMethod,
                $routeUri
            ));
        } else {
            $this->assertEquals($expect, $this->router->matchFixedUri(
                $httpMethod,
                $routeUri
            ));
        }
    }
}
