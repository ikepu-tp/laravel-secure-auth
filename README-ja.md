# Laravel Secure Auth

このパッケージはLaravelにおいて，よりセキュアな認証を追加するパッケージです。

## 使い方

### 1. インストール

```bash
composer require ikepu-tp/laravel-secure-auth
```

### 2. マイグレーション

```bash
php artisan migrate
```

### 3. 設定ファイル

```bash
php artisan vendor:publish --tags=SecureAuth-config
```

必要に応じて設定内容を変更してください。

| キー項目         | 説明                         |
| ---------------- | ---------------------------- |
| expires_minitues | トークンの期限（分）         |
| token_digits     | トークンの桁数               |
| loginCallback    | ログイン処理の関数           |
| login_history    | ログイン履歴を記録するか否か |
| login_email      | ログイン時のメール送信       |

### 2段階認証

> [!IMPORTANT]
> 設定ファイルの`loginCallback`でログイン処理関数の設定を行なってください。

```php:AuthController Sample
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::query()
            ->where("email", $request->validated("email"))
            ->first();
        if (!$user || !Hash::check($request->validated("password"), $user->password)) throw new UnauthorizedException();
        return \ikepu_tp\SecureAuth\app\Http\Services\TfaService::make($user, $request->validated("remember", false));
    }
```

### ログイン履歴の記録

> [!IMPORTANT]
> ログイン処理中にログインイベントを発行してください。

```php Login Function Sample
    public function login(User $user)
    {
        session()->regenerate();
        event(new \ikepu_tp\SecureAuth\app\Events\LoginEvent($user));
        \Illuminate\Support\Facades\Auth::guard($guard)->login($user, $remember);
    }
```

## 貢献

貢献をお待ちしています！

Issue: バグの報告や新機能の提案等
Pull Requests: バグの修正や新機能等の提案

## ライセンス

See [LICENSE](./LICENSE).
