<?php

declare(strict_types=1);

namespace App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes;

/**
 * Enum HandlerExceptionCodesEnum
 *
 * Represents specific exception codes for database handler.
 *
 * @package App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes
 */
enum HandlerExceptionCodesEnum: int
{
    /**
     * Database handler insertion failed
     *
     * This code is used when the database handler fails inserting some data on
     * database
     */
    case FailedInsertion = 1006;

    /**
     * Database handler select failed
     *
     * This code is used when the database handler fails selecting some data on
     * database
     */
    case FailedSelect = 1007;

    /**
     * Database handler update failed
     *
     * This code is used when the database handler fails updating some data on
     * database
     */
    case FailedUpdate = 1008;

    /**
     * Database handler deletion failed
     *
     * This code is used when the database handler fails deleting some data on
     * database
     */
    case FailedDelete = 1009;
}
