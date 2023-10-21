<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class RouterCore
 * 
 * @package src\core
 */
final class RouterCore
{
    /**
     * All defined app routes
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Define a new GET route
     *
     * @param string $routePath
     * @param array $routeCallback
     * @param boolean $routeMiddleware
     * @return void
     */
    public function get(
        string $routePath,
        array $routeCallback,
        array|false $routeMiddleware = false
    ): void {
        $this->routes["GET"][$routePath] = [
            "controller" => $routeCallback,
            "middleware" => $routeMiddleware
        ];
    }

    /**
     * Define a new POST route
     *
     * @param string $routePath
     * @param array $routeCallback
     * @param array|false $routeMiddleware
     * @return void
     */
    public function post(
        string $routePath,
        array $routeCallback,
        array|false $routeMiddleware = false
    ): void {
        $this->routes["POST"][$routePath] = [
            "controller" => $routeCallback,
            "middleware" => $routeMiddleware
        ];
    }
 
    /**
     * Try to match requested URI with defined routes (fixed ones)
     *
     * @param string $httpMethod
     * @param string $routeUri
     * @return array|false
     */
    public function matchFixedUri(string $httpMethod, string $routeUri): array|false
    {
        foreach ($this->routes[$httpMethod] as $key => $value) {
            if ($key === $routeUri) {
                return $this->routes[$httpMethod][$key];
            }
        }

        return false;
    }

    /**
     * Handle request
     *
     * @return void
     */
    public function handleRequest(): void
    {
        $httpMethod = RequestCore::getHttpMethod();
        $routeUri = RequestCore::getRouteUri();
        $matchRoute = $this->matchFixedUri($httpMethod, $routeUri);

        if ($matchRoute === false) {
            ResponseCore::setResponseStatusCode(404);
            ResponseCore::redirectTo("/notfound");
        }

        // Create an instance of route controller
        $matchRoute["controller"][0] = new $matchRoute["controller"][0]();

        // Execute middleware is it's defined
        if (is_array($matchRoute["middleware"])) {
            $matchRoute["middleware"][0] = new $matchRoute["middleware"][0]();

            call_user_func($matchRoute["middleware"]);
        }

        // Execute controller method
        call_user_func($matchRoute["controller"]);
    }

    /**
     * Router::$routes getter
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
