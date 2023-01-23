<?php

namespace dnj\LaravelSimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelSimpleContactFormServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/contact.php', 'contact');
        $this->app->singleton(IFormManager::class, LaravelSimpleContactFormServiceProvider::class);
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                                 __DIR__.'/../config/contact.php' => config_path('contact.php'),
                             ], 'contact-config');
        }
    }

    private function loadRoutes()
    {
        if (config('contact.route_enable')) {
            Route::prefix(config('contact.route_prefix'))
                 ->group(function () {
                     $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
                 });
        }
    }

    private function loadMigrations()
    {
    }
}
