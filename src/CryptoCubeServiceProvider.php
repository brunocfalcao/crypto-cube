<?php

namespace Nidavellir\CryptoCube;

use Illuminate\Support\ServiceProvider;

final class CryptoCubeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->importMigrations();
    }

    protected function importMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
