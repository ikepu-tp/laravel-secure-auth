<?php

return [

    /**
     * ----------------------------------------------------------------
     * Token expires in minutes
     * ----------------------------------------------------------------
     */
    "expires_minutes" => 10,

    /**
     * ----------------------------------------------------------------
     * Token Digits
     * ----------------------------------------------------------------
     */
    "token_digits" => 6,

    /**
     * ----------------------------------------------------------------
     * Login Callback
     * ----------------------------------------------------------------
     *
     * function (\Illuminate\Foundation\Auth\User $user, bool $remember = false, string $guard = null):void
     */
    "loginCallback" => null,
    /*"loginCallback" => function (\Illuminate\Foundation\Auth\User $user, bool $remember = false, string $guard = null): void {
        session()->regenerate();
        event(new \ikepu_tp\SecureAuth\app\Events\LoginEvent($user));
        \Illuminate\Support\Facades\Auth::guard($guard)->login($user, $remember);
    },*/

    /**
     * ----------------------------------------------------------------
     * Login Histories
     * ----------------------------------------------------------------
     */
    "login_history" => true,

    /**
     * ----------------------------------------------------------------
     * Sending Email when Login
     * ----------------------------------------------------------------
     */
    "login_email" => true,

    /**
     * ----------------------------------------------------------------
     * Sending notification which to notify the new device
     * ----------------------------------------------------------------
     */
    "new_device_notification" => true,

    /**
     * ----------------------------------------------------------------
     * New Device Expires
     * ----------------------------------------------------------------
     */
    "new_device_expires" => 10080, // 60m*24h*7days
];