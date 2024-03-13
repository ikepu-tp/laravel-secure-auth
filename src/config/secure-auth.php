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
];
