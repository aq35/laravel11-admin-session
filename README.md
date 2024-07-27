# 管理者セッションパッケージ

このパッケージは、管理者セッションを管理する機能を提供し、管理者ユーザーの作成および取得のためのカスタムコマンドを含んでいます。

## 対応するLaravelのバージョン

このパッケージは、Laravel 11で動作することを想定しています。

### 説明

- **インストール手順**: パッケージをプロジェクトに追加する手順から始まり、Composerの依存関係をインストールし、ミドルウェアを登録し、マイグレーションを実行する手順を記載しています。

- **コマンドの使用方法**: パッケージ内のカスタムコマンド（管理者ユーザーの作成と名前による管理者検索）の使用方法を記載しています

## インストール

### ステップ 1: プロジェクトにパッケージを追加

laravelアプリの直下にpackagesディレクトリを配置してください。

自身の `composer.json`ファイル に「admin-session」パッケージを追加します。

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/your-vendor/admin-session"
        }
    ],
    "require": {
        "your-vendor/admin-session": "dev-master"
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

### ステップ 2: Composerの依存関係をインストール
以下のコマンドを実行して、パッケージの依存関係をインストールします。


```sh
composer update
```

### ステップ 3: ミドルウェアの登録
bootstrap/app.phpにミドルウェアを追加します。

```php
$middleware->api(prepend: [
    \YourVendor\AdminSession\Http\Middleware\UseAdminSession::class,
]);
$middleware->web(prepend: [
    \YourVendor\AdminSession\Http\Middleware\UseAdminSession::class,
]);
```

### ステップ 4: マイグレーションの実行
以下のコマンドを実行して、マイグレーションを実行します。

```sh
php artisan migrate
```

### ステップ 5: パッケージの使用
以下のコマンドを実行して、パッケージのカスタムコマンドを使用します。

#### 管理者ユーザーの作成
このコマンドを使用して、新しい管理者ユーザーを作成できます。

```sh
php artisan create:admin-user

====== 出力例 ==============================
氏名: sample
メールアドレス: sample@sample.com
パスワード: 
===========================================
```

#### 名前で管理者を取得
このコマンドを使用して、部分一致する名前を持つ管理者ユーザーとそのセッション情報を取得できます。

```sh
php artisan get:admins-by-name sample

====== 出力例 ==============================
運営者 詳細:
氏名: sample
メールアドレス: sample@sample.com
セッション情報: なし
ログイン認証済？: No
===========================================
```

