<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
