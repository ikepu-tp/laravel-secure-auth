<?php

namespace ikepu_tp\SecureAuth\app\Listeners;

use ikepu_tp\SecureAuth\app\Events\NewDeviceEvent;
use ikepu_tp\SecureAuth\app\Notifications\NewDeviceNotification;

class NewDeviceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewDeviceEvent $event): void
    {
        if (config("secure-auth.login_email")) $event->user->notify(new NewDeviceNotification($event->sa_login_history));
    }
}