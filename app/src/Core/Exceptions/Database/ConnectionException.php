<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Database;

use Exception;

/**
 * Represents exceptions for the Connection class.
 *
 * @package App\Core\Exceptions\Database
 * @final
 */
final class ConnectionException extends Exception
{
    /**
     * Initializes a ConnectionException components
     *
     * @param string $message ConnectionException message
     * @param int $code ConnectionException code
     * @param null|Exception $previous ConnectionException previous Exception
     * @return void
     */
    public function __construct(string $message, int $code, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get ConnectionException string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . '[' . $this->code . ']:' . $this->message;
    }
}
