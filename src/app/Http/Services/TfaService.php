<?php

namespace ikepu_tp\SecureAuth\app\Http\Services;

use Exception;
use ikepu_tp\SecureAuth\app\Models\Tfa;
use ikepu_tp\SecureAuth\app\Notifications\TFANotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TfaService
{
    protected Tfa|null $tfa;
    protected \Illuminate\Foundation\Auth\User|null $user;
    protected bool $remember = false;
    protected string|null $guard;
    protected string|null $token;
    protected array|null $payload;
    protected \Illuminate\Support\Carbon|null $expired_at;

    /**
     * make TFA
     *  - generage TFA
     *  - send notification
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param array $payload
     * @return RedirectResponse
     */
    static public function make(\Illuminate\Foundation\Auth\User $user, bool $remember = false, array $payload = [], string $guard = null): RedirectResponse
    {
        $static = new static;
        $static->setUser($user);
        $static->setRemember($remember);
        $static->setGuard($guard);
        $static->generate($payload);
        $static->send($user);

        return redirect(route("__tfa.store"));
    }

    public function setUser(\Illuminate\Foundation\Auth\User $user): void
    {
        $this->user = $user;
    }

    public function setRemember(bool $remember = false): void
    {
        $this->remember = $remember;
    }

    public function setGuard(string $guard = null): void
    {
        $this->guard = $guard;
    }

    /**
     * generate TFA
     *
     * @param array $payload
     * @return void
     */
    public function generate(array $payload = []): void
    {
        $this->token = (string)str_pad(rand(0, 999999), config("secure-auth.token_digits", 6), 0, STR_PAD_LEFT);
        $this->payload = $payload;
        $this->expired_at = now();
        $this->expired_at->addMinutes(config("secure-auth.expires_minutes", 10));
        $tfa = Tfa::query()
            ->firstOrNew(
                ["session_id" => session()->getId()],
            );
        $tfa->fill([
            "token" => $this->token,
            "payload" => array_merge(
                $this->payload,
                [
                    "_guard" => $this->guard,
                    "_user_id" => $this->user?->getKey(),
                    "_remember" => $this->remember,
                ]
            ),
            "expired_at" => $this->expired_at->timestamp,
        ]);
        if (!$tfa->save()) throw new Exception("Failed saving token");
        $this->tfa = $tfa;
        session()->put("__tfa.tfa", $this->tfa);
        session()->put("__tfa.user", $this->user);
        session()->put("__tfa.remember", $this->remember);
        session()->put("__tfa.guard", $this->guard);
    }

    /**
     * send token via notification service
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @return void
     */
    public function send(\Illuminate\Foundation\Auth\User $user): void
    {
        if (is_null($this->tfa)) throw new Exception("Undefined token");
        $user->notify(new TFANotification($this->tfa));
    }

    /**
     * attempt token
     *
     * @param string $token
     * @param callable|null $loginCallback
     * @return boolean
     */
    static public function attempt(string $token, callable $loginCallback = null): bool
    {
        $tfa = Tfa::query()
            ->where("session_id", session()->getId())
            ->first();
        if (!$tfa) return false;
        if ($tfa->token !== $token) return false;
        if ($tfa->expired_at < now()->timestamp) return false;

        $user = session()->pull("__tfa.user");
        $remember = session()->pull("__tfa.remember");
        $guard = session()->pull("__tfa.guard");
        if ($loginCallback) {
            $loginCallback($user, $remember, $guard);
        } else {
            static::loginCallback($user, $remember, $guard);
        }

        $tfa->delete();
        static::prune_expired_at();
        return true;
    }

    /**
     * login callback
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param boolean $remember
     * @param string|null $guard
     * @return void
     */
    static public function loginCallback(\Illuminate\Foundation\Auth\User $user, bool $remember = false, string $guard = null): void
    {
        session()->regenerate();
        Auth::guard($guard)->login($user, $remember);
    }

    /**
     * prune expired token
     *
     * @return void
     */
    static public function prune_expired_at(): void
    {
        Tfa::query()
            ->where("expired_at", "<", now()->timestamp)
            ?->delete();
    }
}
