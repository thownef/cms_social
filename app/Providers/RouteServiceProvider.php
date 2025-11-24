<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Default API rate limit: 60 requests per minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Login rate limit: 5 attempts per minute (stricter for security)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many login attempts. Please try again later.',
                    ], 429);
                });
        });

        // Upload rate limit: 10 uploads per minute
        RateLimiter::for('uploads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()->id)
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many upload requests. Please try again later.',
                    ], 429);
                });
        });

        // Search rate limit: 30 searches per minute
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });

        // Messaging rate limit: 100 messages per minute
        RateLimiter::for('messaging', function (Request $request) {
            return Limit::perMinute(100)->by($request->user()->id);
        });
    }
}
