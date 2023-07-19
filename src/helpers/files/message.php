<?php

use src\core\Message;

/**
 * Display a default feedback message
 * @param string $text
 * @return string
 */
function display_default_message(string $text): string
{
    return (new Message())->defineMessage($text, CONF_MESSAGE_DEFAULT);
}

/**
 * Display a info feedback message
 * @param string $text
 * @return string
 */
function display_info_message(string $text): string
{
    return (new Message())->defineMessage($text, CONF_MESSAGE_INFO);
}

/**
 * Display a success feedback message
 * @param string $text
 * @return string
 */
function display_success_message(string $text): string
{
    return (new Message())->defineMessage($text, CONF_MESSAGE_SUCCESS);
}

/**
 * Display a warning feedback message
 * @param string $text
 * @return string
 */
function display_warning_message(string $text): string
{
    return (new Message())->defineMessage($text, CONF_MESSAGE_WARNING);
}

/**
 * Display a error feedback message
 * @param string $text
 * @return string
 */
function display_error_message(string $text): string
{
    return (new Message())->defineMessage($text, CONF_MESSAGE_ERROR);
}