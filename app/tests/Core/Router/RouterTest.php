<?php

declare(strict_types=1);

namespace Tests\Core\Router;

use App\Core\Router\Route;
use App\Core\Router\Router;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Test Router class functionalities
 *
 * @package Tests\Core\Router
 */
final class RouterTest extends TestCase
{
    /**
     * Router instance for testing
     *
     * @var null|Router
     */
    private ?Router $router = null;

    /**
     * Initialize tests components
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new Router();
    }

    /** @dataProvider */
    public static function Router_test_route_creation_data_provider(): array
    {
        return [
            'http_get_method' => [
                'get',
                '/get-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_head_method' => [
                'head',
                '/head-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_post_method' => [
                'post',
                '/post-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_put_method' => [
                'put',
                '/put-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_delete_method' => [
                'delete',
                '/delete-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_connect_method' => [
                'connect',
                '/connect-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_options_method' => [
                'options',
                '/options-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_options_method' => [
                'options',
                '/options-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_trace_method' => [
                'trace',
                '/trace-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ],
            'http_trace_method' => [
                'patch',
                '/patch-route',
                ['ValidControllerCallbackClass', 'validControllerCallbackMethod'],
                ['ValidMiddlewareCallbackClass', 'validMiddlewareCallbackMethod']
            ]
        ];
    }

    /**
     * @test
     * @dataProvider Router_test_route_creation_data_provider
     */
    public function Router_test_route_creation_null_middleware(
        string $routeHttpMethod,
        string $routePath,
        array $routeControllerCallback
    ): void {
        $this->router->$routeHttpMethod($routePath, $routeControllerCallback);

        $actual      = $this->router->getDefinedRoutes();
        $actualRoute = $actual[strtoupper($routeHttpMethod)][0];

        $this->assertArrayHasKey(strtoupper($routeHttpMethod), $actual);
        $this->assertInstanceOf(Route::class, $actualRoute);
        $this->assertEquals($routePath, $actualRoute->routePath);
        $this->assertEquals($routeControllerCallback, $actualRoute->routeControllerCallback);
        $this->assertNull($actualRoute->routeMiddlewareCallback);
    }

    /**
     * @test
     * @dataProvider Router_test_route_creation_data_provider
     */
    public function Router_test_route_creation_non_null_middleware(
        string $routeHttpMethod,
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback
    ): void {
        $this->router->$routeHttpMethod($routePath, $routeControllerCallback, $routeMiddlewareCallback);

        $actual      = $this->router->getDefinedRoutes();
        $actualRoute = $actual[strtoupper($routeHttpMethod)][0];

        $this->assertArrayHasKey(strtoupper($routeHttpMethod), $actual);
        $this->assertInstanceOf(Route::class, $actualRoute);
        $this->assertEquals($routePath, $actualRoute->routePath);
        $this->assertEquals($routeControllerCallback, $actualRoute->routeControllerCallback);
        $this->assertEquals($routeMiddlewareCallback, $actualRoute->routeMiddlewareCallback);
        $this->assertNotNull($actualRoute->routeMiddlewareCallback);
    }

    /** @test */
    public function Router_test_route_matching_non_dynamic_uri(): void
    {
        $this->router->get('/get-route', ['ValidControllerCallbackClass', 'validControllerCallbackMethod']);

        $requestRoute = $this->router->getRequestRoute('GET', '/get-route');

        $this->assertArrayHasKey('request_route', $requestRoute);
        $this->assertInstanceOf(Route::class, $requestRoute['request_route']);
        $this->assertArrayHasKey('request_route_parameters', $requestRoute);
        $this->assertEmpty($requestRoute['request_route_parameters']);
    }

    /** @test */
    public function Router_test_route_matching_dynamic_uri(): void
    {
        $this->router->get('/get-route/{id}/{some_param}', ['ValidControllerCallbackClass', 'validControllerCallbackMethod']);

        $requestRoute = $this->router->getRequestRoute('GET', '/get-route/10/some-parameter');

        $this->assertArrayHasKey('request_route', $requestRoute);
        $this->assertInstanceOf(Route::class, $requestRoute['request_route']);
        $this->assertArrayHasKey('request_route_parameters', $requestRoute);
        $this->assertArrayHasKey('id', $requestRoute['request_route_parameters']);
        $this->assertEquals('10', $requestRoute['request_route_parameters']['id']);
        $this->assertEquals('some-parameter', $requestRoute['request_route_parameters']['some_param']);
    }

    /** @test */
    public function Router_test_route_matching_not_found(): void
    {
        $this->router->get('/get-route', ['ValidControllerCallbackClass', 'validControllerCallbackMethod']);

        $requestRoute = $this->router->getRequestRoute('GET', '/notfound');

        $this->assertNull($requestRoute);
    }
}
