<?php

declare(strict_types=1);

namespace src\core\router;

use src\core\exceptions\enums\router\RouterExceptionCodes;
use src\core\exceptions\router\RouterException;

/**
 * Class Router
 *
 * This class handles the routing logic of the application
 *
 * @package src\core\router
 * @final
 */
final class Router
{
    /**
     * All application defined routes.
     *
     * @var array
     */
    private array $definedRoutes = [];

    /**
     * Route exception code for a invalid route URI
     *
     * @var null|int
     */
    private ?int $invalidRouteUriExceptionCode = null;

    /**
     * Route exception code for a invalid route callback
     *
     * @var null|int
     */
    private ?int $invalidRouteCallback = null;

    /**
     * Initialize Router components
     *
     * @return void
     */
    public function __construct()
    {
        // Initialize route exception codes
        $this->invalidRouteUriExceptionCode = RouterExceptionCodes::InvalidRouteUri->value;
        $this->invalidRouteCallback = RouterExceptionCodes::InvalidRouteCallback->value;
    }

    /**
     * Validate new route components
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback  New route controller callback array with
     * the callback class and method.
     * @param null|array $middlewareCallback New route middleware callback array
     * with the callback class and method.
     * @return void
     * @throws RouterException
     */
    private function validateRouteComponents(string $routeUri, array $controllerCallback, ?array $middlewareCallback): void
    {
        // Validate route URI
        if (empty($routeUri)) {
            throw new RouterException(
                'Route URI can\'t be empty.',
                $this->invalidRouteUriExceptionCode
            );
        }

        // Validate controller callback data
        if (empty($controllerCallback)) {
            throw new RouterException(
                'Route controller callback can\'t be empty',
                $this->invalidRouteCallback
            );
        }

        if (
            !is_string($controllerCallback[0]) ||
            !is_string($controllerCallback[1]) ||
            empty($controllerCallback[0]) ||
            empty($controllerCallback[1])
        ) {
            throw new RouterException(
                'Invalid route controller callback.',
                $this->invalidRouteCallback
            );
        }

        // Validate middleware callback data
        if (!is_null($middlewareCallback)) {
            if (empty($middlewareCallback)) {
                throw new RouterException(
                    'Route middleware callback can\'t be empty',
                    $this->invalidRouteCallback
                );
            }

            if (
                !is_string($middlewareCallback[0]) ||
                !is_string($middlewareCallback[1]) ||
                empty($middlewareCallback[0]) ||
                empty($middlewareCallback[1])
            ) {
                throw new RouterException(
                    'Invalid middleware callback components.',
                    $this->invalidRouteCallback
                );
            }
        }
    }

    /**
     * Define a new route with a HTTP GET method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function get(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['GET'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP HEAD method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function head(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['HEAD'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP POST method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function post(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['POST'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP PUT method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function put(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['PUT'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP DELETE method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function delete(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['DELETE'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP CONNECT method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function connect(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['CONNECT'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP OPTIONS method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function options(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['OPTIONS'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP TRACE method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function trace(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['TRACE'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Define a new route with a HTTP PATCH method
     *
     * @param string $routeUri New route URI.
     * @param array $controllerCallback New route controller callback.
     * @param null|array $middlewareCallback New route middleware callback.
     * @return void
     * @throws RouterException
     */
    public function patch(string $routeUri, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->validateRouteComponents($routeUri, $controllerCallback, $middlewareCallback);

        $this->definedRoutes['PATCH'][$routeUri] = new Route(
            $routeUri,
            $controllerCallback[0],
            $controllerCallback[1],
            $middlewareCallback[0] ?? null,
            $middlewareCallback[1] ?? null
        );
    }

    /**
     * Get defined routes value
     *
     * @return array
     */
    public function getDefinedRoutes(): array
    {
        return $this->definedRoutes;
    }
}
