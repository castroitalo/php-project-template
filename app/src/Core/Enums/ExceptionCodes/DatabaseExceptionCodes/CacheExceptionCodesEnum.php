<?php

declare(strict_types=1);

namespace App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes;

enum CacheExceptionCodesEnum: int
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
