<?php

 declare(strict_types=1);

 namespace App\Notifications;

 use App\Notifications\Channels\FcmChannel;
use App\Notifications\Messages\FcmMessage;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

 // @TB: This is an example. See how to implement this in Dashbord\UsersController
 // This works with Api\Users\FcmRegistrationTokensController
  class UserCreated extends Notification implements ShouldQueue
  {
      use Queueable;

      protected $user;

      /**
       * Create a new notification instance.
       *
       * @return void
       */
      public function __construct(User $user)
      {
          $this->user = $user;
      }

      /**
       * Get the notification's delivery channels.
       *
       * @return array
       */
      public function via($notifiable)
      {
          $fcmToken = $notifiable->routeNotificationFor('fcm');

          if ($fcmToken !== null) {
              return [FcmChannel::class];
          }

          return [];
      }

      /**
       * Get the Fcm representation of the notification.
       *
       * @param  mixed  $notifiable
       * @return FcmMessage
       */
      public function toFcm($notifiable)
      {
          return (new FcmMessage())
              ->to($notifiable->routeNotificationFor('fcm'))
              ->title('Check it out!')
              ->body($this->user->name . ' just joined ' . config('app.name'));
      }
  }
