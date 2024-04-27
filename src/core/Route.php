<?php

declare(strict_types=1);

namespace src\core;

use RuntimeException;

/**
 *
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class Route
{
    /**
     *
     */
    private const AVALIABLE_HTTP_METHODS = [
        'GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH',
    ];

    /**
     *
     * @var null|string
     */
    private ?string $httpMethod = null;

    /**
     *
     * @var null|string
     */
    private ?string $routePath = null;

    /**
     *
     * @var null|array
     */
    private ?array $controllercallback = null;

    /**
     *
     * @var null|array
     */
    private ?array $middlewarecallback = null;

    /**
     *
     * @param string $httpMethod
     * @param string $routePath
     * @param array $controllerCallback
     * @param null|array $middlewareCallback
     * @return void
     * @throws RuntimeException
     */
    public function __construct(string $httpMethod, string $routePath, array $controllerCallback, ?array $middlewareCallback = null)
    {
        // Check if HTTP method is avaliable
        if (! in_array($httpMethod, self::AVALIABLE_HTTP_METHODS)) {
            // throw new RuntimeException("Invalid HTTP method: {$httpMethod}");
            throw new RuntimeException('Invalid HTTP method: ' . $httpMethod);
        }

        $this->httpMethod = $httpMethod;

        // Check if route path is empty
        if (empty($routePath)) {
            throw new RuntimeException('Route path can\'t be empty');
        }

        $this->routePath = $routePath;

        // Check if controller callback is not empty
        if (empty($controllerCallback)) {
            throw new RuntimeException('Route controller callback can\'t be empty.');
        }

        $this->controllercallback = $controllerCallback;

        // If there is a middleware check if it is not empty
        if (! is_null($middlewareCallback) && empty($middlewareCallback)) {
            throw new RuntimeException('Route middleware callback can\'t be empty.');
        }

        $this->middlewarecallback = $middlewareCallback;
    }

    /**
     *
     * @return null|string
     */
    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    /**
     *
     * @return null|string
     */
    public function getRoutePath(): ?string
    {
        return $this->routePath;
    }

    /**
     *
     * @return array
     */
    public function getControllerCallback(): array
    {
        return $this->controllercallback;
    }

    /**
     *
     * @return null|array
     */
    public function getMiddlewareCallback(): ?array
    {
        return $this->middlewarecallback;
    }
}
