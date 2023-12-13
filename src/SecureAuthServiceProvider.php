<?php

namespace ikepu_tp\SecureAuth;

use ikepu_tp\SecureAuth\app\Events\TFAEvent;
use ikepu_tp\SecureAuth\app\Listeners\TFAListener;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;

class SecureAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/secure-auth.php', 'secure-auth');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
        $this->defineRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . "/resources/views", "SecureAuth");
        Event::listen(TFAEvent::class, TFAListener::class);
        Paginator::useBootstrap();
        Blade::componentNamespace("ikepu_tp\\resources\\views\\components", "SecureAuth");
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {
        if (!$this->app->runningInConsole()) return;

        $this->publishes([
            __DIR__ . '/config/secure-auth.php' => base_path('config/secure-auth.php'),
        ], 'SecureAuth-config');


        $this->publishMigration();
        $this->publishView();
        $this->publishAsset();
    }

    private function publishMigration(): void
    {
        $migrations = [];
        foreach ($migrations as $migration) {
            $this->publishes([
                __DIR__ . "/database/migrations/{$migration}" => database_path(
                    "migrations/{$migration}"
                ),
            ], 'migrations');
        }
    }

    private function publishView(): void
    {
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/SecureAuth'),
        ], 'SecureAuth-views');
    }

    private function publishAsset(): void
    {
        $this->publishes([], 'SecureAuth-assets');
    }

    /**
     * Define the routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php");
    }
}