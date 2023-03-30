<?php

namespace dnj\SimpleContactForm\Tests;

use dnj\SimpleContactForm\Contracts\IFormManager;
use dnj\SimpleContactForm\FormManager;
use dnj\SimpleContactForm\ServiceProvider as SimpleContactFormServiceProvider;
use dnj\UserLogger\ServiceProvider as UserLoggerServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    public function getFormManager(): FormManager
    {
        return $this->app->make(IFormManager::class);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            UserLoggerServiceProvider::class,
            SimpleContactFormServiceProvider::class,
        ];
    }
}
