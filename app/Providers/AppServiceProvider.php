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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Automatically ensure images upload directory exists and is writable
        try {
            $imagesPath = public_path('images');
            if (!is_dir($imagesPath)) {
                @mkdir($imagesPath, 0755, true);
            }
        } catch (\Exception $e) {
            // Suppress errors during boot to prevent crash
        }
    }
}
