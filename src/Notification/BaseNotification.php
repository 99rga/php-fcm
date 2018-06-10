<?php

namespace g9rga\phpFcm\src\Notification;

class BaseNotification implements ArrayInterface
{
    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $body = '';

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }
}
