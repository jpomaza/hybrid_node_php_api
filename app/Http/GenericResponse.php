<?php

namespace App\Http;

class GenericResponse
{
    /**
     * The message or group of messages to communicate a response status.
     *
     * @var string|array
     */
    public $message;

    /**
     * Creates a new generic response instance.
     *
     * @param string|array $message The message or group of messages to communicate a response status.
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }
}
