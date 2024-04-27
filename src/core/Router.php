<?php

declare(strict_types=1);

namespace src\core;

/**
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class Router
{
    /**
     *
     * @var array
     */
    private array $routes = [];

    /**
     *
     */
    private const PATH_PATTERNS = [
        '(:alpha)' => '[a-z\-]+',
        '(:numeric)' => '[0-9]+',
        '(:alphanumeric)' => '[a-z0-9\-]+',
    ];

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function get(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['GET'][] = new Route('GET', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function head(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['HEAD'][] = new Route('HEAD', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function post(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['POST'][] = new Route('POST', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function put(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['PUT'][] = new Route('PUT', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function delete(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['DELETE'][] = new Route('DELETE', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function connect(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['CONNECT'][] = new Route('CONNECT', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function options(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['OPTIONS'][] = new Route('OPTIONS', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function trace(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['TRACE'][] = new Route('TRACE', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param string $path
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     */
    public function patch(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes['PATCH'][] = new Route('PATCH', $path, $controllerCallback, $middlewareCallback);
    }

    /**
     *
     * @param array $routes
     * @param string $path
     * @return null|Route
     */
    public function matchPath(array $routes, string $path): ?Route
    {
        foreach ($routes as $route) {
            $pathPattern = str_replace('/', '\/', ltrim($route->getRoutePath(), '/'));

            /**
             * Replace the template for the regex pattern to match the requested route
             */
            if (str_contains($pathPattern, '(:alpha)')) {
                $pathPattern = str_replace('(:alpha)', self::PATH_PATTERNS['(:alpha)'], $pathPattern);
            }

            if (str_contains($pathPattern, '(:numeric)')) {
                $pathPattern = str_replace('(:numeric)', self::PATH_PATTERNS['(:numeric)'], $pathPattern);
            }

            if (str_contains($pathPattern, '(:alphanumeric)')) {
                $pathPattern = str_replace('(:alphanumeric)', self::PATH_PATTERNS['(:alphanumeric)'], $pathPattern);
            }

            // Match requested route with the defined route
            if (preg_match('/^' . $pathPattern . '$/', ltrim($path, '/'))) {
                return $route;
            }
        }

        return null;
    }

    /**
     *
     * @param Route $route
     * @param string $path
     * @return array
     */
    public function getDynamicPathParameters(Route $route, string $path): array
    {
        $requestPathArray = explode('/', ltrim($path, '/'));
        $routePathArray = explode('/', ltrim($route->getRoutePath(), '/'));
        $pathDiff = array_diff($requestPathArray, $routePathArray);
        $parameters = [];

        foreach ($pathDiff as $key => $value) {
            $parameters[$requestPathArray[$key - 1]] = $value;
        }

        return $parameters;
    }

    /**
     *
     * @param Route $route
     * @param null|array $parameters
     * @return void
     */
    public function runControlle(Route $route, ?array $parameters): void
    {
        $routeControllerClass = $route->getControllerCallback()[0];
        $routeControllerMethod = $route->getControllerCallback()[1];
        $routeControllerObject = new $routeControllerClass();

        call_user_func([$routeControllerObject, $routeControllerMethod], $parameters);
    }

    /**
     *
     * @param Route $route
     * @param null|array $parameters
     * @return void
     */
    public function runMiddleware(Route $route, ?array $parameters): void
    {
        $routeMiddlewareClass = $route->getMiddlewareCallback()[0];
        $routeMiddlewareMethod = $route->getMiddlewareCallback()[1];
        $routeMiddlewareObject = new $routeMiddlewareClass();

        // Check if there is any parameters
        if (! is_null($parameters)) {
            call_user_func([$routeMiddlewareObject, $routeMiddlewareMethod], $parameters);
        } else {
            call_user_func([$routeMiddlewareObject, $routeMiddlewareMethod]);
        }
    }

    /**
     *
     * @param string $httpMethod
     * @param string $path
     * @return void
     */
    public function handleRequest(string $httpMethod, string $path): void
    {
        $avaliableRoutes = $this->routes[$httpMethod];
        $route = $this->matchPath($avaliableRoutes, $path);
        $routeParameters = null;

        // If matchPath() didn't match any request path with route path
        if (is_null($route)) {
            echo "Page not found";
        }

        // Get dynamic path parameters
        if (
            str_contains($route->getRoutePath(), '(:alpha)') ||
            str_contains($route->getRoutePath(), '(:numeric)') ||
            str_contains($route->getRoutePath(), '(:alphanumeric)')
        ) {
            $routeParameters = $this->getDynamicPathParameters($route, $path);
        }

        // Execute middleware if there is one
        if (!is_null($route->getMiddlewareCallback())) {
            $this->runMiddleware($route, $routeParameters);
        }

        $this->runControlle($route, $routeParameters);
    }

    /**
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
