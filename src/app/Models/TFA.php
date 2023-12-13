<?php

namespace ikepu_tp\SecureAuth\app\Models;

use DateTime;
use ikepu_tp\SecureAuth\app\Events\TFAEvent;

class TFA
{
    public string $value = "";
    public bool $auth = false;
    public string $expired_at = "";
    public bool $valid = false;

    function __construct(array $tfa = [])
    {
        $tfa = array_merge(
            $this->getTFA(),
            $tfa
        );
        if (isset($tfa["value"]) && is_string($tfa["value"])) $this->value = $tfa["value"];
        if (isset($tfa["auth"]) && is_bool($tfa["auth"])) $this->auth = $tfa["auth"];
        if (isset($tfa["expired_at"]) && is_string($tfa["expired_at"])) $this->expired_at = $tfa["expired_at"];
        $this->isValid();
    }

    /**
     * 値の有無
     *
     * @return boolean
     */
    public function isValid(): bool
    {
        $this->valid =
            !empty($this->value) && !empty($this->expired_at);
        return $this->valid;
    }

    public function toArray(): array|null
    {
        if ($this->isValid())
            return [
                "value" => $this->value,
                "auth" => $this->auth,
                "expired_at" => $this->expired_at,
            ];
        return null;
    }

    /**
     * TFA作成
     *
     * @return void
     */
    public function generateTFA(): void
    {
        if ($this->isValid()) return;
        $this->value = (string)str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
        $this->auth = false;
        $this->expired_at = now()->addMinutes(config("secure-auth.expires_minutes", 10));
        $this->valid = true;
    }

    public function revokeTFA(): void
    {
        $this->value = "";
        $this->auth = false;
        $this->expired_at = "";
        $this->valid = false;
        $this->setTFA(null);
    }

    /**
     * TFA設定
     *
     * @return void
     */
    public function setTFA(array|null $value = null): void
    {
        if (is_null($value) && !$this->isValid()) {
            $this->generateTFA();
            $value = $this->toArray();
        }
        session()->push("__tfa", $value);
        event(new TFAEvent($this));
    }

    public function getTFA(): array
    {
        $tfa = session("__tfa", []);
        return $tfa ? $tfa[0] : [];
    }

    /**
     * TFA認証
     *
     * @param string $tfa_token
     * @return boolean
     */
    public static function authorizeTFA(string $tfa_token): bool
    {
        $tfa = new static();
        $tfa->auth = (
            !$tfa->isValid() ||
            $tfa->isExpired() ||
            !$tfa->checkToken($tfa_token)
        );
        $tfa->setTFA($tfa->toArray());
        return $tfa->auth;
    }

    /**
     * 有効期限切れ
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        $now = now()->getTimestamp();
        $expired_at = (new DateTime($this->expired_at))->getTimestamp();
        return $now > $expired_at;
    }

    /**
     * トークンの一致確認
     *
     * @param string $tfa_token
     * @return boolean
     */
    public function checkToken(string $tfa_token): bool
    {
        return $this->value === $tfa_token;
    }
}