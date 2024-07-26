<?php

declare(strict_types=1);

namespace App\Core\Enums\ExceptionCodes\RouterExceptionCodes;

/**
 * Enum RouteExceptionCodesEnum
 *
 * Represents specific exception codes for a new route creation.
 *
 * @package CastroItalo\EchoQuery\enums\exceptions
 */
enum RouteExceptionCodesEnum: int
{
    /**
     * InvalidRoutePath
     *
     * This code is used when the Route class definition comes with an invaid
     * route path string.
     */
    case InvalidRoutePath = 1000;

    /**
     * InvalidRouteControllerCallback
     *
     * This code is used when the Route class definition comes with a invalid
     * route controller callback array
     */
    case InvalidRouteControllerCallback = 1001;

    /**
     * InvalidRouteMiddlewareCallback
     *
     * This code is used when the Route class definition comes with a invalid
     * route middleware callback array
     */
    case InvalidRouteMiddlewareCallback = 1002;
}
