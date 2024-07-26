<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\Enums\ExceptionCodes\RouterExceptionCodes\RouteExceptionCodesEnum;
use App\Core\Exceptions\Router\RouteException;

/**
 * Route object for routing system.
 *
 * @package App\Core\Router
 */
final class Route
{
    /**
     * Initialize route components
     *
     * @param string $routePath Route path that will be used to identify HTTP
     * requests.
     * @param array $routeControllerCallback Route controller callback tells
     * what code should run for each route path.
     * @param null|array $routeMiddlewareCallback Route middleware callback tells
     * what code should run before the controller callback.
     * @return void
     */
    public function __construct(
        readonly string $routePath,
        readonly array  $routeControllerCallback,
        readonly ?array $routeMiddlewareCallback        = null,
        private  int    $invalidRoutePath               = RouteExceptionCodesEnum::InvalidRoutePath->value,
        private  int    $invalidRouteControllerCallback = RouteExceptionCodesEnum::InvalidRouteControllerCallback->value,
        private  int    $invalidRouteMiddlewareCallback = RouteExceptionCodesEnum::InvalidRouteMiddlewareCallback->value
    ) {
        // Validate route path
        if (empty($routePath) || !is_string($routePath)) {
            throw new RouteException(
                'Invalid route path: ' . $routePath,
                $invalidRoutePath
            );
        }

        // Validate route controller callback
        if (empty($routeControllerCallback)) {
            throw new RouteException(
                'Route controller callback can\'t be empty.',
                $invalidRouteControllerCallback
            );
        }

        if (sizeof($routeControllerCallback) > 2 || sizeof($routeControllerCallback) < 2) {
            throw new RouteException(
                'Route controller must have a class and method definition only.',
                $invalidRouteControllerCallback
            );
        }

        if (!is_string($routeControllerCallback[0]) || !is_string($routeControllerCallback[1])) {
            throw new RouteException(
                'Route controller must have a class and method definition only.',
                $invalidRouteControllerCallback
            );
        }

        // Validate route middleware controller
        if (!is_null($routeMiddlewareCallback)) {
            if (empty($routeMiddlewareCallback)) {
                throw new RouteException(
                    'Route middleware callback can\'t be empty.',
                    $invalidRouteMiddlewareCallback
                );
            }

            if (sizeof($routeMiddlewareCallback) > 2 || sizeof($routeMiddlewareCallback) < 2) {
                throw new RouteException(
                    'Route middleware must have a class and method definition only.',
                    $invalidRouteMiddlewareCallback
                );
            }

            if (!is_string($routeMiddlewareCallback[0]) || !is_string($routeMiddlewareCallback[1])) {
                throw new RouteException(
                    'Route middleware must have a class and method definition only.',
                    $invalidRouteMiddlewareCallback
                );
            }
        }
    }
}
