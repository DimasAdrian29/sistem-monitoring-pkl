<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// TAMBAHKAN DUA BARIS INI UNTUK RENDER HOOK
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Auth\Login::class)

            // --- PENGATURAN LOGO DI SINI ---
            ->brandName('Sistem Monitoring PKL')
            ->brandLogo(asset('images/logo_sekolah.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo_sekolah.png'))
            // -------------------------------

            // --- KATA-KATA SELAMAT DATANG DI HALAMAN LOGIN ---
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): string => Blade::render('<div class="text-center mb-2 mt-4"><h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sistem Informasi PKL SMKN 5 Pekanbaru</p></div>')
            )
            // -------------------------------------------------

            ->colors([
                'primary' => '#0d6dfd',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\AdminPanelAccessMiddleware::class,
            ]);
    }
}
