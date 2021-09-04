<?php

namespace Nidavellir\CryptoCube;

use Illuminate\Support\ServiceProvider;
use Nidavellir\CryptoCube\Models\Token;
use Nidavellir\CryptoCube\Observers\TokenObserver;

final class CryptoCubeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->importMigrations();
        $this->loadObservers();
    }

    protected function importMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function loadObservers()
    {
        Token::observe(TokenObserver::class);
    }
}
