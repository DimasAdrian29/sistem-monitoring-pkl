<?php
namespace App\Providers;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Daftarkan custom login response
        $this->app->singleton(LoginResponse::class, \App\Http\Responses\LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
