<?php

declare(strict_types=1);

namespace src\core\exceptions\enums\router;

/**
 * Enum RouterExceptionCode
 *
 * Represents specific exception codes for routing operations.
 *
 * @package src\core\exceptions\enums\router
 */
enum RouterExceptionCodes: int
{
    /**
     * Invalid route URI
     *
     * This code is used when the provided route URI are empty.
     */
    case InvalidRouteUri = 1000;

    /**
     * Invalid route callback
     *
     * This code is used when the provided route callback is empty, or one of the
     * mandatory components (class, method, both strings) is empty.
     */
    case InvalidRouteCallback = 1001;
}
