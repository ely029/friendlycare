<?php

declare(strict_types=1);

namespace App\Notifications\Messages;

// @TB: See FcmChannel
class FcmMessage
{
    private $to = null;
    private $title = null;
    private $body = null;

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function body($body)
    {
        $this->body = $body;

        return $this;
    }

    public function toArray()
    {
        return [
            'to' => $this->to,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
            ],
        ];
    }
}
