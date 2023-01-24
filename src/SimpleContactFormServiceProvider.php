<?php

namespace dnj\SimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SimpleContactFormServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/contact.php', 'contact');
        $this->app->register(\dnj\UserLogger\ServiceProvider::class);
        $this->app->singleton(IFormManager::class, ContactManager::class);
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                                 __DIR__.'/../config/contact.php' => config_path('contact.php'),
                             ], 'config');
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
}
