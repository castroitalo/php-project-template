<?php

declare(strict_types=1);

namespace src\core\router;

/**
 * Class Route
 *
 * This class represents a new route in the app
 *
 * @package src\core\router
 * @final
 */
final class Route
{
    /**
     * Route URI
     *
     * @var null|string
     */
    private ?string $routeUri = null;

    /**
     * Route controller callback class to execute
     *
     * @var null|string
     */
    private ?string $controllerCallbackClass = null;

    /**
     * Route controller callback method to execute
     *
     * @var null|string
     */
    private ?string $controllerCallbackMethod = null;

    /**
     * Route middleware callback class to execute
     *
     * @var null|string
     */
    private ?string $middlewareCallbackClass = null;

    /**
     * Route middleware callback method to execute
     *
     * @var null|string
     */
    private ?string $middlewareCallbackMethod = null;

    /**
     * Initialize route components
     *
     * @param string $routeUri Route URI
     * @param string $controllerCallbackClass Route controller callback class to execute
     * @param string $controllerCallbackMethod Route controller callback method to execute
     * @param null|string $middlewareCallbackClass Route middleware callback class to execute
     * @param null|string $middlewareCallbackMethod Route middleware callback method to execute
     * @return void
     */
    public function __construct(
        string $routeUri,
        string $controllerCallbackClass,
        string $controllerCallbackMethod,
        ?string $middlewareCallbackClass = null,
        ?string $middlewareCallbackMethod = null
    ) {
        $this->routeUri = $routeUri;
        $this->controllerCallbackClass = $controllerCallbackClass;
        $this->controllerCallbackMethod = $controllerCallbackMethod;
        $this->middlewareCallbackClass = $middlewareCallbackClass;
        $this->middlewareCallbackMethod = $middlewareCallbackMethod;
    }

    /**
     * Get route URI value
     *
     * @return string
     */
    public function getRouteUri(): string
    {
        return $this->routeUri;
    }

    /**
     * Get route controller callback class value
     *
     * @return string
     */
    public function getControllerCallbackClass(): string
    {
        return $this->controllerCallbackClass;
    }

    /**
     * Get route controller callback method value
     *
     * @return string
     */
    public function getControllerCallbackMethod(): string
    {
        return $this->controllerCallbackMethod;
    }

    /**
     * Get route middleware callback class value
     *
     * @return null|string
     */
    public function getMiddlewareCallbackClass(): ?string
    {
        return $this->middlewareCallbackClass;
    }

    /**
     * Get route middleware callback method value
     *
     * @return null|string
     */
    public function getMiddlewareCallbackMethod(): ?string
    {
        return $this->middlewareCallbackMethod;
    }
}
