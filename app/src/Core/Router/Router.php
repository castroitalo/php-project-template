<?php

declare(strict_types=1);

namespace App\Core\Router;

/**
 * Application routing system
 *
 * @package App\Core\Router
 * @final
 */
final class Router
{
    /**
     * Dynamic route patterns
     */
    private const ROUTE_PATH_PATTERNS = [
        '(:alpha)'        => '[a-z\-]+',
        '(:numeric)'      => '[0-9]+',
        '(:alphanumeric)' => '[a-z0-9\-]+'
    ];

    /**
     * Initialize Router components
     */
    public function __construct(
        private array $definedRoutes = [],
    ) {
    }

    /**
     * Add a HTTP GET route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function get(
        string $routePath,
        array  $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['GET'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Get application's defined routes
     *
     * @return array
     */
    public function getDefinedRoutes(): array
    {
        return $this->definedRoutes;
    }
}
