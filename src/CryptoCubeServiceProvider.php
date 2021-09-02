<?php

namespace Nidavellir\CryptoCube;

use Illuminate\Support\ServiceProvider;
use Nidavellir\CryptoCube\Models\Candlestick;
use Nidavellir\CryptoCube\Models\Symbol;
use Nidavellir\CryptoCube\Observers\CandlestickObserver;
use Nidavellir\CryptoCube\Observers\SymbolObserver;

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
        Symbol::observe(SymbolObserver::class);
        Candlestick::observe(CandlestickObserver::class);
    }
}
