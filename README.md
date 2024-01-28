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

| key entries      | description               |
| ---------------- | ------------------------- |
| expires_minitues | token_expires_minutes     |
| token_digits     | number of digits in token |
| loginCallback    | function of login process |

## Contributtion

We welcome contributions to the project! You can get involved through the following ways:

Issue: Use for bug reports, feature suggestions, and more.
Pull Requests: We encourage code contributions for new features and bug fixes.

## License

See [LICENSE](./LICENSE).
