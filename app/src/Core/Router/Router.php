<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Modules\Error\Controllers\ErrorController;

/**
 * Application routing system
 *
 * @package App\Core\Router
 * @final
 */
final class Router
{
    /**
     * Initialize Router components
     */
    public function __construct(
        private array $definedRoutes = []
    ) {
        // Defined application's default routes
        $this->definedRoutes['GET'][] = new Route(
            $_ENV['ROUTE_ERROR_PAGE_NOT_FOUND'],
            [ErrorController::class, 'pageNotFound']
        );
        $this->definedRoutes['GET'][] = new Route(
            $_ENV['ROUTE_ERROR_INTERNAL_SERVER_ERROR'],
            [ErrorController::class, 'pageNotFound']
        );
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
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['GET'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP HEAD route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function head(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['HEAD'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP POST route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function post(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['POST'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP PUT route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function put(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['PUT'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP DELETE route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function delete(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['DELETE'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP CONNECT route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function connect(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['CONNECT'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP OPTIONS route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function options(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['OPTIONS'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP TRACE route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function trace(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['TRACE'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Add a HTTP PATCH route to the application defined routes
     *
     * @param string $routePath Route path
     * @param array $routeControllerCallback Route controller callback
     * @param null|array $routeMiddlewareCallback Route middleware callback
     * @return void
     */
    public function patch(
        string $routePath,
        array $routeControllerCallback,
        ?array $routeMiddlewareCallback = null
    ): void {
        $this->definedRoutes['PATCH'][] = new Route(
            $routePath,
            $routeControllerCallback,
            $routeMiddlewareCallback
        );
    }

    /**
     * Extract request URI parameters values if the URI is dynamic
     *
     * @param string $routePath Request URI
     * @param array $uriPatternMatches Request URI matches
     * @return array
     */
    private function extractUriParametersValues(string $routePath, array $uriPatternMatches): array
    {
        preg_match_all('/\{([^\}]+)\}/', $routePath, $paramNames);

        return array_combine($paramNames[1], $uriPatternMatches);
    }

    /**
     * Get request route if matches any application's defined route
     *
     * @param string $httpRequestMethod HTTP request method
     * @param string $requestUri Request URI
     * @return null|array
     */
    public function getRequestRoute(string $httpRequestMethod, string $requestUri): ?array
    {
        foreach ($this->definedRoutes[$httpRequestMethod] as $route) {
            $uriPattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route->routePath);
            $uriPattern = "#^" . $uriPattern . "$#";

            if (preg_match($uriPattern, $requestUri, $uriPatternMatches)) {
                array_shift($uriPatternMatches);

                $uriPatameters = $this->extractUriParametersValues($route->routePath, $uriPatternMatches);

                return [
                    'request_route'            => $route,
                    'request_route_parameters' => $uriPatameters
                ];
            }
        }

        return null;
    }

    /**
     * Execute route callbacks, controller and middleware (if there is one).
     *
     * @param array $requestRoute Matched request route array
     * @return void
     */
    public function executeControllerCallback(array $requestRoute): void
    {
        // Extract controller callback info
        $routeCallbackInfo                 = $requestRoute['request_route'];
        $routeControllerCallbackParameters = $requestRoute['request_route_parameters'];
        $routeControllerCallbackClass      = $routeCallbackInfo->routeControllerCallback[0];
        $routeControllerCallbackMethod     = $routeCallbackInfo->routeControllerCallback[1];
        $routeMiddlewareCallbackClass      = $routeCallbackInfo->routeMiddlewareCallback[0] ?? null;
        $routeMiddlewareCallbackMethod     = $routeCallbackInfo->routeMiddlewareCallback[1] ?? null;

        // Execute route middleware callback
        if (!is_null($routeMiddlewareCallbackClass)) {
            $routeMiddlewareCallbackObject = new $routeMiddlewareCallbackClass();

            call_user_func([$routeMiddlewareCallbackObject, $routeMiddlewareCallbackMethod]);
        }

        // Execute route controller callback
        $routeControllerCallbackObject = new $routeControllerCallbackClass();

        call_user_func([$routeControllerCallbackObject, $routeControllerCallbackMethod], $routeControllerCallbackParameters);
    }

    /**
     * Handles request URI
     *
     * @param string $httpRequestMethod HTTP request method
     * @param string $requestUri Request URI
     * @return void
     */
    public function handleRequest(string $httpRequestMethod, string $requestUri): void
    {
        $requestRoute = $this->getRequestRoute($httpRequestMethod, $requestUri);

        if (is_null($requestRoute)) {
            $requestRoute = $this->getRequestRoute('GET', '/page-not-found');
        }

        $this->executeControllerCallback($requestRoute);
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
