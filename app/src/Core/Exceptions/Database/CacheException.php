<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Database;

use Exception;

/**
 * Represents exceptions for the Cache class.
 *
 * @package App\Core\Exceptions\Database
 * @final
 */
final class CacheException extends Exception
{
    /**
     * Initializes a CacheException components
     *
     * @param string $message CacheException message
     * @param int $code CacheException code
     * @param null|Exception $previous CacheException previous Exception
     * @return void
     */
    public function __construct(string $message, int $code, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get CacheException string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . '[' . $this->code . ']:' . $this->message;
    }
}
