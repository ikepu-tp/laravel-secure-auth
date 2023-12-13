<?php

namespace ikepu_tp\SecureAuth\app\Listeners;

use ikepu_tp\SecureAuth\app\Events\TFAEvent;
use ikepu_tp\SecureAuth\app\Notifications\TFANotify;
use Illuminate\Support\Facades\Auth;

class TFAListener
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
    public function handle(mixed $event): void
    {
        if (!$event instanceof TFAEvent) return;
        $user = Auth::guard(config("secure-auth.guard"))->user();
        if (
            is_null($user) ||
            !method_exists($user, "notify")
        ) return;
        $user->notify(new TFANotify($event->tfa));
    }
}