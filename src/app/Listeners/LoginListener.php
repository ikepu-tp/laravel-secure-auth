<?php

namespace ikepu_tp\SecureAuth\app\Listeners;

use ikepu_tp\SecureAuth\app\Events\LoginEvent;
use ikepu_tp\SecureAuth\app\Models\Sa_login_history;
use ikepu_tp\SecureAuth\app\Notifications\LoginNotification;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

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
        $agent = new Agent();
        $device = $agent->deviceType();
        $browser = $agent->browser();

        $sa_login_history = new Sa_login_history();
        $sa_login_history->fill([
            "loginId" => Str::uuid(),
            "user_id" => $event->user->getKey(),
            "ip_address" => Request::ip(),
            "user_agent" => Request::userAgent(),
            "device" => $device,
            "browser" => $browser,
        ]);
        $sa_login_history->save();

        if (config("secure-auth.login_email")) $event->user->notify(new LoginNotification($sa_login_history));
    }
}