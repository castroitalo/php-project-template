<?php

namespace Source\Support;

/**
 * 
 * Class Message
 * @package Source\Core
 */
class Message
{

    /**
     * 
     * @var string
     */
    private string $text;

    /**
     * 
     * @var string
     */
    private string $type;

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return "<div class='{$this->type}'>{$this->text}</div>";
    }

    /**
     * 
     * @param string $text
     * @return string
     */
    private function filterText(string $text): string
    {
        return filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * 
     * @param string $text
     * @return Message
     */
    public function info(string $text): Message
    {
        $this->type = CONF_MESSAGE_INFO;
        $this->text = $this->filterText($text);

        return $this;
    }

    /**
     * 
     * @param string $text
     * @return Message
     */
    public function success(string $text): Message
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $this->filterText($text);

        return $this;
    }

    /**
     * 
     * @param string $text
     * @return Message
     */
    public function warning(string $text): Message
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $this->filterText($text);

        return $this;
    }

    /**
     * 
     * @param string $text
     * @return Message
     */
    public function error(string $text): Message
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $this->filterText($text);

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function json(): string
    {
        return json_encode([
            "error" => $this->getText()
        ]);
    }

    /**
     * 
     * @return void
     */
    public function flash(): void
    {
        (new Session())->set("flash", $this);
    }

    /**
     * 
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * 
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}
