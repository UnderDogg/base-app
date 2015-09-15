<?php

namespace App\Http;

class Flash
{
    /**
     * Generates a new session flash message.
     *
     * @param string $title
     * @param string $message
     * @param string $level
     * @param string $key
     */
    public function create($title, $message, $level = 'info', $key = 'flash_message')
    {
        session()->flash($key, [
            'title' => $title,
            'message' => $message,
            'level' => $level,
        ]);
    }

    /**
     * Generates an info flash message.
     *
     * @param string $title
     * @param string $message
     */
    public function info($title, $message)
    {
        $this->create($title, $message, 'info');
    }

    /**
     * Generates an success flash message.
     *
     * @param string $title
     * @param string $message
     */
    public function success($title, $message)
    {
        $this->create($title, $message, 'success');
    }

    /**
     * Generates an warning flash message.
     *
     * @param string $title
     * @param string $message
     */
    public function warning($title, $message)
    {
        $this->create($title, $message, 'warning');
    }

    /**
     * Generates an error flash message.
     *
     * @param string $title
     * @param string $message
     */
    public function error($title, $message)
    {
        $this->create($title, $message, 'error');
    }

    /**
     * Generates an overlay flash message.
     *
     * @param string $title
     * @param string $message
     * @param string $level
     */
    public function overlay($title, $message, $level)
    {
        $this->create($title, $message, $level, 'flash_message_overlay');
    }
}
