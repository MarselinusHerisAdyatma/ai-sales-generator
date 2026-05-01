<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS jika aplikasi berjalan di Railway (production)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
