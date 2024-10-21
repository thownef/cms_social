<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (scandir(app_path('Repositories')) as $file) {
            if (str_contains($file, '.php')) {
                $model = str_replace('Repository.php', '', $file);
                $this->app->singleton(
                    "App\\Contracts\\Repositories\\{$model}RepositoryInterface",
                    "App\\Repositories\\{$model}Repository"
                );
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
