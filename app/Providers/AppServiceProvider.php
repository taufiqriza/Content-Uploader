<?php

namespace App\Providers;

use App\Services\ConnectorManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register ConnectorManager as singleton
        $this->app->singleton(ConnectorManager::class, function ($app) {
            return new ConnectorManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
