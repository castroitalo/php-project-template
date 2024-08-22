<?php

declare(strict_types=1);

namespace App\Core\Enums\ExceptionCodes\ConnectionExceptionCodes;

/**
 * Enum ConnectionExceptionCodesEnum
 *
 * Represents specific exception codes for a new singleton databsae connection
 * creation.
 *
 * @package CastroItalo\EchoQuery\enums\exceptions
 */
enum ConnectionExceptionCodesEnum: int
{
    /**
     * Database connection creation failed
     *
     * This code is used when the singletong database connection fails
     */
    case FailedConnection = 1003;
}
