<?php

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\Router;
use src\models\Route;
use stdClass;

/**
 * Router test case
 * 
 * @package tests\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @access public
 * @final
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("^10.3")]
final class RouterTest extends TestCase
{
    /**
     * Router object for test case
     *
     * @var Router|null
     */
    private ?Router $router = null;

    /**
     * Setup Router object for test case
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new Router();
    }

    /**
     * Test Router HTTP method route definition data provider
     *
     * @return array
     */
    public static function routeHttpMethodsTestDataProvider(): array
    {
        return [
            "get_method" => ["GET"],
            "head_method" => ["HEAD"],
            "post_method" => ["HEAD"],
            "put_method" => ["PUT"],
            "delete_method" => ["DELETE"],
            "connect_method" => ["CONNECT"],
            "options_method" => ["OPTIONS"],
            "trace_method" => ["TRACE"],
            "patch_method" => ["PATCH"]
        ];
    }

    /**
     * Test Router HTTP method route definition
     *
     * @param string $httpMethod
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    #[DataProvider("routeHttpMethodsTestDataProvider")]
    public function testRouteHttpMethods(string $httpMethod): void
    {
        $this->router->$httpMethod("/path", [stdClass::class, "method"]);

        $this->assertNotEmpty($this->router->getRoutes()[strtoupper($httpMethod)]);
    }

    /**
     * Test Router match path method, returns Route object is the path matches 
     * and null if it don't
     *
     * @return void
     */
    public function testRouterMatchPath(): void
    {
        $this->router->get("/test/(:alpha)", [stdClass::class, "method"]);
        $this->router->get("/test", [stdClass::class, "method"]);

        $actualTestOne = $this->router->matchPath($this->router->getRoutes()["GET"], "/test/parameter");
        $actualTestTwo = $this->router->matchPath($this->router->getRoutes()["GET"], "/test");
        $actualTestThree = $this->router->matchPath($this->router->getRoutes()["GET"], "/dont/exists");

        $this->assertInstanceOf(Route::class, $actualTestOne);
        $this->assertInstanceOf(Route::class, $actualTestTwo);
        $this->assertNull($actualTestThree);
    }

    /**
     * Get the dynamic path parameter for alpha template
     *
     * @return void
     */
    public function testRouterGetDynamicPathParametersAlphaTemplate(): void
    {
        $this->router->get("/page/(:alpha)", [stdClass::class, "method"]);

        $route = $this->router->matchPath($this->router->getRoutes()["GET"], "/page/pageone");
        $actual = $this->router->getDynamicPathParameters($route, "/page/pageone");

        $this->assertEquals(["page" => "pageone"], $actual);
    }

    /**
     * Get the dynamic path parameter for numeric template
     *
     * @return void
     */
    public function testRouterGetDynamicPathParametersNumericTemplate(): void
    {
        $this->router->get("/page/(:numeric)", [stdClass::class, "method"]);

        $route = $this->router->matchPath($this->router->getRoutes()["GET"], "/page/1");
        $actual = $this->router->getDynamicPathParameters($route, "/page/1");

        $this->assertEquals(["page" => 1], $actual);
    }

    /**
     * Get the dynamic path parameter for alphanumeric template
     *
     * @return void
     */
    public function testRouterGetDynamicPathParametersAlphaNumericTemplate(): void
    {
        $this->router->get("/page/(:alphanumeric)", [stdClass::class, "method"]);

        $route = $this->router->matchPath($this->router->getRoutes()["GET"], "/page/page1");
        $actual = $this->router->getDynamicPathParameters($route, "/page/page1");

        $this->assertEquals(["page" => "page1"], $actual);
    }

    /**
     * Get the dynamic path parameter for multiples template
     *
     * @return void
     */
    public function testRouterGetDynamicPathParametersMultiplesTemplates(): void
    {
        $this->router->get("/profile/(:alpha)/page/(:numeric)", [stdClass::class, "method"]);

        $route = $this->router->matchPath($this->router->getRoutes()["GET"], "/profile/personone/page/1");
        $actual = $this->router->getDynamicPathParameters($route, "/profile/personone/page/1");

        $this->assertEquals(["profile" => "personone", "page" => 1], $actual);
    }
}
