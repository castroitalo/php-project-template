<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\exceptions\router\RouterException;
use src\core\router\Router;

/**
 * Class RouterTest
 *
 * This class test every functionality of the Router class.
 *
 * @package src\core\router
 * @final
 */
#[RequiresPhp('^8.2')]
#[RequiresPhpunit('^10.5')]
final class RouterTest extends TestCase
{
    /**
     * Router object for testing
     *
     * @var null|Router
     */
    private ?Router $router = null;

    /**
     * Test case setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new Router();
    }

    /** @test */
    public function validateRouteComponents_invalid_route_uri(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1000);
        $this->expectExceptionMessage('Route URI can\'t be empty.');

        $this->router->get('', [stdClass::class, 'method'], null);
    }

    /** @test */
    public function validateRouteComponents_empty_controller_callback(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Route controller callback can\'t be empty');

        $this->router->get('/', [], null);
    }

    /** @test */
    public function validateRouteComponents_empty_controller_callback_class(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Invalid route controller callback.');

        $this->router->get('/', ['', 'method'], null);
    }

    /** @test */
    public function validateRouteComponents_empty_controller_callback_method(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Invalid route controller callback.');

        $this->router->get('/', [stdClass::class, ''], null);
    }

    /** @test */
    public function validateRouteComponents_empty_middleware_callback(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Route middleware callback can\'t be empty');

        $this->router->get('/', [stdClass::class, 'method'], []);
    }

    /** @test */
    public function validateRouteComponents_empty_middleware_callback_class(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Invalid middleware callback components.');

        $this->router->get('/', [stdClass::class, 'method'], ['', 'method']);
    }

    /** @test */
    public function validateRouteComponents_empty_middleware_callback_method(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionCode(1001);
        $this->expectExceptionMessage('Invalid middleware callback components.');

        $this->router->get('/', [stdClass::class, 'method'], [stdClass::class, '']);
    }

    /** @test */
    public function adding_correct_routes_to_defined_routes(): void
    {
        $this->router->get('/', [stdClass::class, 'method']);
        $this->router->get('/another/uri', [stdClass::class, 'method']);
        $actual = $this->router->getDefinedRoutes();

        $this->assertArrayHasKey('GET', $actual);
        $this->assertEquals(2, count($actual['GET']));
    }

    /** @test */
    public function validating_route_definition_structure_with_null_middleware(): void
    {
        $this->router->get('/', [stdClass::class, 'method']);
        $actual = $this->router->getDefinedRoutes();

        $this->assertArrayHasKey('GET', $actual);

        $this->assertObjectHasProperty('routeUri', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getRouteUri());

        $this->assertObjectHasProperty('controllerCallbackClass', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getControllerCallbackClass());

        $this->assertObjectHasProperty('controllerCallbackMethod', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getControllerCallbackMethod());

        $this->assertObjectHasProperty('middlewareCallbackClass', $actual['GET']['/']);
        $this->assertTrue(is_null($actual['GET']['/']->getMiddlewareCallbackClass()));

        $this->assertObjectHasProperty('middlewareCallbackMethod', $actual['GET']['/']);
        $this->assertTrue(is_null($actual['GET']['/']->getMiddlewareCallbackMethod()));
    }

    /** @test */
    public function validating_route_definition_structure_with_non_null_middleware(): void
    {
        $this->router->get('/', [stdClass::class, 'method'], [stdClass::class, 'method']);
        $actual = $this->router->getDefinedRoutes();

        $this->assertArrayHasKey('GET', $actual);

        $this->assertObjectHasProperty('routeUri', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getRouteUri());

        $this->assertObjectHasProperty('controllerCallbackClass', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getControllerCallbackClass());

        $this->assertObjectHasProperty('controllerCallbackMethod', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getControllerCallbackMethod());

        $this->assertObjectHasProperty('middlewareCallbackClass', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getMiddlewareCallbackClass());

        $this->assertObjectHasProperty('middlewareCallbackMethod', $actual['GET']['/']);
        $this->assertIsString($actual['GET']['/']->getMiddlewareCallbackMethod());
    }
}
