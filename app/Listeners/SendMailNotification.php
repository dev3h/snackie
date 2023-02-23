<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Notifications\UserRegisteredNotificationMail;
use Illuminate\Support\Facades\Notification;

class SendMailNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        Notification::send($event->user, new UserRegisteredNotificationMail($event->user));
    }
}
