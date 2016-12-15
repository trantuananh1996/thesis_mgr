<?php

namespace App\Http;

/**
 * Class Flash
 * @package App\Http
 */
class Flash
{

    /**
     * @param $title
     * @param $message
     * @param $level
     * @param string $key
     */
    public function create($title, $message, $level, $key = 'flash_message')
    {
        session()->flash($key, [
            'title'   => $title,
            'message' => $message,
            'level'   => $level
        ]);
    }

    /**
     * @param $title
     * @param $message
     */
    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    /**
     * @param $title
     * @param $message
     */
    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    /**
     * @param $title
     * @param $message
     */
    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    /**
     * @param $title
     * @param $message
     * @param string $level
     */
    public function overlay($title, $message, $level = 'success')
    {
        return $this->create($title, $message, $level, 'flash_message_overlay');
    }
}