<?php

namespace dnj\SimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/contact.php', 'contact');
        $this->app->singleton(IFormManager::class, ContactManager::class);
    }

    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/contact.php' => config_path('contact.php'),
            ], 'config');
        }
    }

    private function loadRoutes(): void
    {
        if (!config('contact.route_enable')) {
            return;
        }
        Route::prefix(config('contact.route_prefix'))->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }
}
