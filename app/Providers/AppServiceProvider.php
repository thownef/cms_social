<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Contracts\Services\AuthenticationServiceInterface::class,
            fn() => new \App\Services\AuthenticationService
        );
        $this->app->singleton(
            \App\Contracts\Services\S3ServiceInterface::class,
            fn () => new \App\Services\S3Service
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
