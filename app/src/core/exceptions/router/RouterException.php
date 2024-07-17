<?php

declare(strict_types=1);

namespace src\core\exceptions\router;

use Exception;

/**
 * Class Router
 *
 * This class handles the routing logic of the application
 *
 * @package src\core\exceptions\router
 * @final
 */
final class RouterException extends Exception
{
    /**
     * Initialize router exceptions components
     *
     * @param string $message Router exception message
     * @param int $code Router exception code
     * @param null|Exception $previous Router exception previous exception
     * @return void
     */
    public function __construct(string $message, int $code, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the exception string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . '[' . $this->code . ']: ' . $this->message . '\n' . $this->getTraceAsString();
    }
}
