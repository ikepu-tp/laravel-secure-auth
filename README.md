# Laravel Secure Auth

This package adds more secure authentication in Laravel.

[Japanese](./README-ja.md)

## Usage

### 1. install

```bash
composer require ikepu-tp/laravel-secure-auth
```

### 2. migration

```bash
php artisan migrate
```

### 3. Configuration files

```bash
php artisan vendor:publish --tags=SecureAuth-config
```

Change the configuration as necessary.

| key entries      | description                            |
| ---------------- | -------------------------------------- |
| expires_minitues | token_expires_minutes                  |
| token_digits     | number of digits in token              |
| loginCallback    | function of login process              |
| login_history    | Whether to record login history or not |
| login_email      | send an email which notify login       |

### Two-factor authentication

> [!IMPORTANT]
> Set up the login handling function in the `loginCallback` configuration file.

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

### Record Login History

> [!IMPORTANT]
> Issue a login event during the login process.

```php Login Function Sample
    public function login(User $user)
    {
        session()->regenerate();
        event(new \ikepu_tp\SecureAuth\app\Events\LoginEvent($user));
        \Illuminate\Support\Facades\Auth::guard($guard)->login($user, $remember);
    }
```

## Contributtion

We welcome contributions to the project! You can get involved through the following ways:

Issue: Use for bug reports, feature suggestions, and more.
Pull Requests: We encourage code contributions for new features and bug fixes.

## License

See [LICENSE](./LICENSE).
