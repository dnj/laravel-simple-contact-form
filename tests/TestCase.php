<?php

namespace dnj\LaravelSimpleContactForm\Test;

use dnj\LaravelSimpleContactForm\LaravelSimpleContactFormServiceProvider;
use dnj\SimpleContactForm\Contracts\IFormManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSimpleContactFormServiceProvider::class,
        ];
    }

    public function getContactManager(): IFormManager
    {
        return $this->app->make(IFormManager::class);
    }
}
