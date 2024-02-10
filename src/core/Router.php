<?php

declare(strict_types=1);

namespace src\core;

use src\models\Route;

/**
 * Router class handles all the HTTP request to the app,
 * matching both fixed and dynamic paths and calling the 
 * right controller and middleware for each defined route.
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
     * Defined app's routes
     *
     * @var array
     */
    private array $routes = array();

    /**
     * Dynamic route pattern
     *
     * @var array
     */
    private const PATH_PATTERNS = [
        "(:alpha)" => "[a-z\-]+",
        "(:numeric)" => "[0-9]+",
        "(:alphanumeric)" => "[a-z0-9\-]+"
    ];

    /**
     * Define a new route with HTTP GET method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function get(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["GET"][] = new Route("GET", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP HEAD method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function head(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["HEAD"][] = new Route("HEAD", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP POST method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function post(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["POST"][] = new Route("POST", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP PUT method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function put(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["PUT"][] = new Route("PUT", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP DELETE method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function delete(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["DELETE"][] = new Route("DELETE", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP CONNECT method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function connect(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["CONNECT"][] = new Route("CONNECT", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP OPTIONS method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function options(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["OPTIONS"][] = new Route("OPTIONS", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP TRACE method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function trace(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["TRACE"][] = new Route("TRACE", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Define a new route with HTTP PATCH method
     *
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     * @return void
     */
    public function patch(string $path, array $controllerCallback, ?array $middlewareCallback = null): void
    {
        $this->routes["PATCH"][] = new Route("PATCH", $path, $controllerCallback, $middlewareCallback);
    }

    /**
     * Search inside routes passed as a parameter for the requested path.
     * Returns the Route object if the requested path is equal to the Route
     * object's path, and null if is not equal.
     *
     * @param array $routes
     * @param string $path
     * @return Route|null
     */
    public function matchPath(array $routes, string $path): ?Route
    {
        foreach ($routes as $route) {
            $pathPattern = str_replace("/", "\/", ltrim($route->getPath(), "/"));

            /**
             * Replace the template for the regex pattern to match the requested route
             */
            if (str_contains($pathPattern, "(:alpha)")) {
                $pathPattern = str_replace("(:alpha)", self::PATH_PATTERNS["(:alpha)"], $pathPattern);
            }

            if (str_contains($pathPattern, "(:numeric)")) {
                $pathPattern = str_replace("(:numeric)", self::PATH_PATTERNS["(:numeric)"], $pathPattern);
            }

            if (str_contains($pathPattern, "(:alphanumeric)")) {
                $pathPattern = str_replace("(:alphanumeric)", self::PATH_PATTERNS["(:alphanumeric)"], $pathPattern);
            }

            // Match requested route with the defined route
            if (preg_match("/^{$pathPattern}$/", ltrim($path, "/"))) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Get dynamic path parameters. Ex:
     * 
     * For path: /page/1
     * The method will return: ["page" => 1]
     *
     * @param Route $route
     * @param string $path
     * @return array
     */
    public function getDynamicPathParameters(Route $route, string $path): array
    {
        $requestPathArray = explode("/", ltrim($path, "/"));
        $routePathArray = explode("/", ltrim($route->getPath(), "/"));
        $pathDiff = array_diff($requestPathArray, $routePathArray);
        $parameters = array();

        foreach ($pathDiff as $key => $value) {
            $parameters[$requestPathArray[$key - 1]] = $value;
        }

        return $parameters;
    }

    /**
     * Run route controller. Extract the class and method names with getControllerCallback()
     * method and call it using call_user_fun function.
     *
     * @param Route $route
     * @param array|null $parameters
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
     * Run route middleware. Extract the class and method names with getMiddlewareCallback()
     * method and call it using call_user_fun function.
     *
     * @param Route $route
     * @param array|null $parameters
     * @return void
     */
    public function runMiddleware(Route $route, ?array $parameters): void
    {
        $routeMiddlewareClass = $route->getMiddlewareCallback()[0];
        $routeMiddlewareMethod = $route->getMiddlewareCallback()[1];
        $routeMiddlewareObject = new $routeMiddlewareClass();

        // Check if there is any parameters
        if (!is_null($parameters)) {
            call_user_func([$routeMiddlewareObject, $routeMiddlewareMethod], $parameters);
        } else {
            call_user_func([$routeMiddlewareObject, $routeMiddlewareMethod]);
        }
    }

    /**
     * Execute controller callback (and middleware if there is one) for the 
     * requested path, and HTTP method.
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
            Response::setResponseStatusCode(404);
            echo "PAGE NOT FOUND";
            exit();
        }

        // Get dynamic path parameters
        if (
            str_contains($route->getPath(), "(:alpha)") ||
            str_contains($route->getPath(), "(:numeric)") ||
            str_contains($route->getPath(), "(:alphanumeric)")
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
     * Get defined routes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
