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
use Hardikkhorasiya09\ChangePassword\ChangePasswordPlugin;
use App\Filament\Pages\Auth\Login;
use Filament\View\PanelsRenderHook;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('SmartPanel')
            ->authGuard('admin')
             ->favicon(asset('images/logo.png'))
            ->brandName('Perpustakaan Kemenag RI')
            ->brandLogo(asset('images/logo.png'))
            ->login(Login::class)
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                PanelsRenderHook::TOPBAR_START,
                fn () => view('filament.topbar-breadcrumb'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                function () {
                    $settings = \App\Models\WebsiteSetting::get();
                    $fontFamily = match($settings->website_font ?? 'plus_jakarta_sans') {
                        'poppins' => "'Poppins', sans-serif",
                        'outfit' => "'Outfit', sans-serif",
                        'inter' => "'Inter', sans-serif",
                        'verdana' => "Verdana, Geneva, sans-serif",
                        default => "'Plus Jakarta Sans', sans-serif",
                    };
                    return new \Illuminate\Support\HtmlString("
                        " . app(\Illuminate\Foundation\Vite::class)(['resources/css/app.css']) . "
                        <style>
                            :root, body, .fi-body, .fi-sidebar, .fi-topbar, .fi-header, .fi-modal, .fi-section, .fi-ta, .fi-fo {
                                --font-sans: {$fontFamily} !important;
                                font-family: var(--font-sans) !important;
                            }
                            .tox-tinymce {
                                width: 100% !important;
                                min-width: 100% !important;
                            }
                        </style>
                    ");
                }
            )
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                'Layanan ISBN',
                'Layanan Digital',
                'Formulir',
                'Feedback',
                'Manajemen Web',
                'Tentang',
                'Pengaturan',
                'Manajemen User',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
                \App\Filament\Pages\DatabaseBackup::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
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
                \App\Http\Middleware\UpdateLastSeen::class,
            ])
            ->plugins([
                ChangePasswordPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ]);
    }
    
}
