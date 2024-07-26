<?php

declare(strict_types=1);

namespace Tests\Core\Router;

use App\Core\Enums\ExceptionCodes\RouterExceptionCodes\RouteExceptionCodesEnum;
use App\Core\Exceptions\Router\RouteException;
use App\Core\Router\Route;
use PHPUnit\Framework\TestCase;

/**
 * Test Route class functionalities
 *
 * @package Tests\Core\Router
 */
final class RouteTest extends TestCase
{
    /** @test */
    public function Route_test_valid_route_creation_null_middleware(): void
    {
        $actual = new Route(
            '/',
            ['ValidControllerClass', 'validControllerMethod']
        );

        $this->assertInstanceOf(Route::class, $actual);
    }

    /** @test */
    public function Route_test_valid_route_creation_non_null_middleware(): void
    {
        $actual = new Route(
            '/',
            ['ValidControllerClass', 'validControllerMethod'],
            ['ValidMiddlewareClass', 'validMiddlewareMethod']
        );

        $this->assertInstanceOf(Route::class, $actual);
    }

    /** @test */
    public function Route_test_invalid_route_creation_empty_route_path(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRoutePath->value);
        $this->expectExceptionMessage('Invalid route path: ' . '');
        new Route('', ['ValidControllerClass', 'validControllerMethod']);
    }

    /** @test */
    public function Route_test_invalid_route_creation_empty_controller_callback(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteControllerCallback->value);
        $this->expectExceptionMessage('Route controller callback can\'t be empty.');
        new Route('/', []);
    }

    /** @test */
    public function Route_test_invalid_route_creation_more_controller_callback_elements(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteControllerCallback->value);
        $this->expectExceptionMessage('Route controller must have a class and method definition only.');
        new Route('/', ['ValidControllerClass', 'validControllerMethod', 'anotherInvalidThing']);
    }

    /** @test */
    public function Route_test_invalid_route_creation_less_controller_callback_elements(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteControllerCallback->value);
        $this->expectExceptionMessage('Route controller must have a class and method definition only.');
        new Route('/', ['ValidControllerClass']);
    }

    /** @test */
    public function Route_test_invalid_route_creation_empty_middleware_callback(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteMiddlewareCallback->value);
        $this->expectExceptionMessage('Route middleware callback can\'t be empty.');
        new Route('/', ['ValidControllerClass', 'validControllerMethod'], []);
    }

    /** @test */
    public function Route_test_invalid_route_creation_more_middleware_callback_elements(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteMiddlewareCallback->value);
        $this->expectExceptionMessage('Route middleware must have a class and method definition only.');
        new Route('/', ['ValidControllerClass', 'validControllerMethod'], ['ValidMiddlewareClass', 'validControllerMethod', 'anotherInvalidThing']);
    }

    /** @test */
    public function Route_test_invalid_route_creation_less_middleware_callback_elements(): void
    {
        $this->expectException(RouteException::class);
        $this->expectExceptionCode(RouteExceptionCodesEnum::InvalidRouteMiddlewareCallback->value);
        $this->expectExceptionMessage('Route middleware must have a class and method definition only.');
        new Route('/', ['ValidControllerClass', 'validControllerMethod'], ['ValidMiddlewareClass']);
    }
}
