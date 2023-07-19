<?php

namespace src\core;

/**
 * Class FeedbackMessage
 * @package src\core
 */
class Message
{

    /**
     * Message text content
     * @var string
     */
    private string $messageText;

    /**
     * Message type
     * @var string
     */
    private string $messageType;

    /**
     * Define a new message
     * @param string $text
     * @param string $type
     * @return string
     */
    public function defineMessage(string $text, string $type): string
    {
        $this->messageText = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->messageType = $type;

        return "<div class='alert alert-{$this->messageType}' role='alert'>{$this->messageText}</div>";
    }

    /**
     * Get current message text content
     * @return string
     */
    public function getMessageText(): string
    {
        return $this->messageText;
    }

    /**
     * Get current message type
     * @return string
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }
}