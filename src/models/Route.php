<?php

declare(strict_types=1);

namespace src\models;

use RuntimeException;

/**
 * Route represents a web route.
 * 
 * Route class needs the route path, the route HTTP method,
 * the route controller callback and if it needs, the route
 * middleware callback.
 * 
 * @package src\models
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class Route
{
    /**
     * Route HTTP method
     *
     * @var string|null
     */
    private ?string $httpMethod = null;

    /**
     * Route path
     *
     * @var string|null
     */
    private ?string $path = null;

    /**
     * Route controller callback
     *
     * @var array|null
     */
    private ?array $controllerCallback = null;

    /**
     * Route middleware callback
     *
     * @var array|null
     */
    private ?array $middlewareCallback = null;

    /**
     * Initialize Route object properties
     *
     * @param string $httpMethod
     * @param string $path
     * @param array $controllerCallback
     * @param array|null $middlewareCallback
     */
    public function __construct(
        string $httpMethod,
        string $path,
        array $controllerCallback,
        ?array $middlewareCallback = null
    ) {
        // Check if the informed HTTP method is avaliable
        if (!in_array($httpMethod, CONF_URL_AVALIABLE_HTTP_METHODS)) {
            throw new RuntimeException(
                "Route HTTP method can only be one of these: " . implode(", ", CONF_URL_AVALIABLE_HTTP_METHODS)
            );
        }

        $this->httpMethod = $httpMethod;

        // Path can't be empty
        if (empty($path)) {
            throw new RuntimeException("Route path can't be empty.");
        }

        $this->path = $path;

        // Check if the controller callback is an empty array
        if (empty($controllerCallback)) {
            throw new RuntimeException("Route controller callback can't be an empty array.");
        }

        $this->controllerCallback = $controllerCallback;

        // Check if the middleware callback is an empty array
        if (!is_null($middlewareCallback)) {
            if (empty($middlewareCallback)) {
                throw new RuntimeException("Route middleware callback can't be an empty array.");
            }

            $this->middlewareCallback = $middlewareCallback;
        }
    }

    /**
     * Route->httpMethod getter
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Route->path getter
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Route->controllerCallback getter
     *
     * @return array
     */
    public function getControllerCallback(): array
    {
        return $this->controllerCallback;
    }

    /**
     * Route->middlewareCallback getter
     *
     * @return array|null
     */
    public function getMiddlewareCallback(): ?array
    {
        return $this->middlewareCallback;
    }
}
