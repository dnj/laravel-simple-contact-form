<?php

namespace dnj\SimpleContactForm\Test;

use dnj\SimpleContactForm\Contracts\IFormManager;
use dnj\SimpleContactForm\SimpleContactFormServiceProvider;
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
            SimpleContactFormServiceProvider::class,
        ];
    }

    public function getContactManager(): IFormManager
    {
        return $this->app->make(IFormManager::class);
    }
}
