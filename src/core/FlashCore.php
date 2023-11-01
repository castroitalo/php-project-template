<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class FlashCore
 *
 * @package src\core
 */
class FlashCore
{
    /**
     * Flash message
     *
     * @var string $flashMessage
     */
    private string $flashMessage;

    /**
     * Flash type (danger, warning, info, success)
     *
     * @var string $flashType
     */
    private string $flashType;  

    /**
     * FlashCore constructor
     *
     * @param string $flashMessage
     * @param string $flashType
     */
    public function __construct(string $flashMessage, string $flashType)
    {
        $this->flashMessage = $flashMessage;
        $this->flashType = $flashType;
    }

    /**
     * Get flash HTML code to be displayed
     *
     * @return string
     */
    public function getFlash(): string 
    {
        return "<div class='flash flash-{$this->flashType}'>{$this->flashMessage}</div>";
    }

    /**
     * Flash message getter
     *
     * @return string 
     */
    public function getFlashMessage(): string
    {
        return $this->flashMessage;
    }

    /**
     * Flash type getter
     *
     * @return string
     */
    public function getFlashType(): string
    {
        return $this->flashType;
    }
}
