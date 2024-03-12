<?php

namespace ikepu_tp\SecureAuth\app\Listeners;

use ikepu_tp\SecureAuth\app\Events\LoginEvent;

class LoginListener
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
    public function handle(LoginEvent $event): void
    {
    }
}