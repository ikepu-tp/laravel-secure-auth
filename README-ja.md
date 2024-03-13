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

### Two-factor authentication

> [!info]
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
        if (!$user) throw new UnauthorizedException();
        return TfaService::make($user, $request->validated("remember", false));
    }
```

## 貢献

貢献をお待ちしています！

Issue: バグの報告や新機能の提案等
Pull Requests: バグの修正や新機能等の提案

## ライセンス

See [LICENSE](./LICENSE).
