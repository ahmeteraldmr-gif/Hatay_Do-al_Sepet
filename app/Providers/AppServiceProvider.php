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
        $this->app->bind('path.public', function() {
            // Case 1: Sibling public_html directory (typical secure cPanel layout)
            if (is_dir(base_path('../public_html'))) {
                return realpath(base_path('../public_html'));
            }
            // Case 2: Parent directory is public_html (typical subfolder layout)
            if (basename(base_path()) !== 'public_html' && is_dir(base_path('../')) && basename(realpath(base_path('../'))) === 'public_html') {
                return realpath(base_path('../'));
            }
            // Default Laravel setup
            return base_path('public');
        });
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
