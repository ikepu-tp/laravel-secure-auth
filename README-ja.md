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

| キー項目         | 説明                 |
| ---------------- | -------------------- |
| expires_minitues | トークンの期限（分） |
| token_digits     | トークンの桁数       |
| loginCallback    | ログイン処理の関数   |

## 貢献

貢献をお待ちしています！

Issue: バグの報告や新機能の提案等
Pull Requests: バグの修正や新機能等の提案

## ライセンス

See [LICENSE](./LICENSE).
