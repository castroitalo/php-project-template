<?php

namespace src\core;

/**
 * Class Route
 * @package src\core
 */
class Route
{
    /**
     * Route uri
     * @var string $uri
     */
    private string $uri;

    /**
     * Route HTTP method
     * @var string $httpMethod
     */
    private string $httpMethod;

    /**
     * Route callback, a string with class and method or a closure
     * @var mixed $callback
     */
    private mixed $callback;

    /**
     * Route middleware, a string with class and method or a closure
     * @var mixed $middleware
     */
    private mixed $middleware;

    /**
     * Route constructor
     * @param string $uri
     * @param string $httpMethod
     * @param mixed $callback
     */
    public function __construct(
        string $uri,
        string $httpMethod,
        mixed $callback,
        mixed $middleware
    ) {
        $this->uri = $uri;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
        $this->middleware = $middleware;
    }

    /**
     * Get route uri
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get route HTTP method
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Get route callback
     * @return mixed
     */
    public function getCallback(): mixed
    {
        return $this->callback;
    }

    /**
     * Get route middleware
     * @return mixed
     */
    public function getMiddleware(): mixed 
    {
        return $this->middleware;
    }
}