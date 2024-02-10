<?php

declare(strict_types=1);

namespace src\core;

/**
 * Create flash logic and body for flash messages in front-end
 * 
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
abstract class Flash
{
    /**
     * Get session value that represents the flash message
     *
     * @return string
     */
    public static function getMessage(): string
    {
        return Session::getValue(CONF_FLASH_MESSAGE);
    }

    /**
     * Get session value that represents the flash type
     *
     * @return string
     */
    public static function getType(): string
    {
        return Session::getValue(CONF_FLASH_TYPE);
    }

    /**
     * Returns a HTML code for the front-end to display the flash message
     *
     * @return string
     */
    public static function getHtml(): string
    {
        $flashMessage = self::getMessage();
        $flashType = self::getType();

        Session::unsetValue(CONF_FLASH_MESSAGE);
        Session::unsetValue(CONF_FLASH_TYPE);

        return <<<HTML
            <div class="alert alert-{$flashType}" role="alert">{$flashMessage}</div>
        HTML;
    }
}
