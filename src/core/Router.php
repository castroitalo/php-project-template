<?php

namespace src\core;

/**
 * Class Router
 * @package src\core
 */
class Router
{
    /**
     * Current app routes
     * @var array $routes
     */
    private array $routes = [];

    /**
     * Current callback separator
     * @var string $separator
     */
    private string $separator;

    /**
     * Router constructor
     * @param string $separator
     */
    public function __construct(string $separator)
    {
        $this->separator = $separator;
    }

    /**
     * Add a Route object to routes array
     * @param string $routeUri
     * @param string $routeHttpMethod
     * @param mixed $routeCallback 
     * @return void
     */
    public function addRoute(
        string $routeUri,
        string $routeHttpMethod,
        mixed $routeCallback,
        mixed $middleware = null
    ): void {
        $this->routes[] = new Route($routeUri, $routeHttpMethod, $routeCallback, $middleware);
    }

    public function executeMiddleware(mixed $middleware) 
    {
        if ($middleware instanceof \Closure) {
            call_user_func($middleware);

            return;
        }

        $middlewareClass = CONF_NAMESPACE_MIDDLEWARES . strstr($middleware, $this->separator, true);
        $middlewareMethod = str_replace($this->separator, "", strstr($middleware, $this->separator));

        if (class_exists($middlewareClass)) {
            $newMiddleware = new $middlewareClass;

            if (method_exists($middlewareClass, $middlewareMethod)) {
                $newMiddleware->$middlewareMethod();
            }
        }
    }

    /**
     * Execute route callback
     * @param Route $route
     * @return void
     */
    private function dispathRoute(Route $route): void
    {
        if ($route->getCallback() instanceof \Closure) {
            call_user_func($route->getCallback());

            return;
        }

        $callbackClass = CONF_NAMESPACE_CONTROLLERS . strstr($route->getCallback(), $this->separator, true);
        $callbackMethod = str_replace($this->separator, "", strstr($route->getCallback(), $this->separator));

        if (class_exists($callbackClass)) {
            $newController = new $callbackClass;

            if (method_exists($callbackClass, $callbackMethod)) {
                if ($route->getMiddleware()) {
                    $this->executeMiddleware($route->getMiddleware());
                }

                $newController->$callbackMethod();
            }
        }
    }

    /**
     * Handle app request
     * @param string $requedtedUri
     * @param string $requestedMethod
     * @param return void 
     */
    public function handleRequest(string $requestedUri, string $requestedMethod): void
    {
        foreach ($this->routes as $route) {
            if (
                $requestedMethod === $route->getHttpMethod()
                && $requestedUri === $route->getUri()
            ) {
                $this->dispathRoute($route);

                return;
            }
        }

        $this->dispathRoute(new Route("", "", "ErrorsController@notFound", null));
    }

    /**
     * Get current web routes
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get current callback separator
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }
}