<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Router;

use Exception;

/**
 * Represents exceptions for the Route class.
 *
 * @package App\Core\Exceptions\Router
 * @final
 */
final class RouteException extends Exception
{
    /**
     * Initializes a RouteException components
     *
     * @param string $message RouteException message
     * @param int $code RouteException code
     * @param null|Exception $previous RouteException previous Exception
     * @return void
     */
    public function __construct(string $message, int $code, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get RouteException string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . '[' . $this->code . ']:' . $this->message;
    }
}
