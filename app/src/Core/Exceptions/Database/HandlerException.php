<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Database;

use Exception;

/**
 * Represents exceptions for the Handler class.
 *
 * @package App\Core\Exceptions\Database
 * @final
 */
final class HandlerException extends Exception
{
    /**
     * Initializes a HandlerException components
     *
     * @param string $message HandlerException message
     * @param int $code HandlerException code
     * @param null|Exception $previous HandlerException previous Exception
     * @return void
     */
    public function __construct(string $message, int $code, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get HandlerException string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . '[' . $this->code . ']:' . $this->message;
    }
}
