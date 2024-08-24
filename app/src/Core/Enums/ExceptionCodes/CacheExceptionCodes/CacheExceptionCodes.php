<?php

declare(strict_types=1);

namespace App\Core\Enums\ExceptionCodes\CacheExceptionCodes;

/**
 * Enum CacheExceptionCodes
 *
 * Represents specific exception codes for a new singleton Redis cache database
 *
 * @package CastroItalo\EchoQuery\enums\exceptions
 */
enum CacheExceptionCodes: int
{
    /**
     * Redis connection creation failed
     *
     * This code is used when the singletong REdis database connection fails
     */
    case FailedRedisConnection = 1004;

    /**
     * Redis key deletion failed
     *
     * This code is used when the Redis failed deleting a key from database
     */
    case FailedDeleteKey = 1005;
}
