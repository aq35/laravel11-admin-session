<?php

namespace YourVendor\AdminSession\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use YourVendor\AdminSession\Extensions\DatabaseAdminSessionHandler;

class AdminSessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/adminsession.php', 'adminsession'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // adminsession.phpの設定ファイルを公開
        $this->publishes([
            __DIR__ . '/../config/adminsession.php' => config_path('adminsession.php'),
        ]);

         // セッションハンドラをカスタマイズして、admin_sessionsテーブルを使用する
        Session::extend('admin_database', function ($app) {
            $connection = $app['db']->connection($this->getConnection());

            return new DatabaseAdminSessionHandler(
                $connection,
                $this->getTable(),
                $this->getLifetime(),
                $app
            );
        });

        // コンソールコマンドの実行時にのみ動作
        if ($this->app->runningInConsole()) {
            // マイグレーションを読み込む
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            // コマンドを登録
            // docker-compose exec app php artisan create:admin-user
            // docker-compose exec app php artisan get:admins-by-name sample
            $this->commands([
                \YourVendor\AdminSession\Console\Commands\CreateAdminUser::class,
                \YourVendor\AdminSession\Console\Commands\GetAdminsByName::class,
            ]);
        }
    }

    /**
     * Get the database connection for the session.
     *
     * @return string
     */
    protected function getConnection()
    {
        return config('session.connection');
    }

    /**
     * Get the database table for the session.
     *
     * @return string
     */
    protected function getTable()
    {
        return config('adminsession.table', 'admin_sessions');
    }

    /**
     * Get the lifetime of the session.
     *
     * @return int
     */
    protected function getLifetime()
    {
        return config('session.lifetime') * 60;
    }
}