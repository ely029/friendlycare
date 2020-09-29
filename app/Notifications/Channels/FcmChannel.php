<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\Http\Clients\FcmClient;

// @TB: [Laravel Notification Channels](https://laravel-notification-channels.com/fcm/)
// [does not support sending to device groups](https://firebase-php.readthedocs.io/en/stable/cloud-messaging.html).
class FcmChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed|\Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, $notification)
    {
        app(FcmClient::class)->sendMessage($notification->toFcm($notifiable));
    }
}
