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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            if (isset($user->role) && $user->role === 'superadmin') {
                return true;
            }
        });

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            [\App\Listeners\LogUserActivity::class, 'handle']
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Logout::class,
            [\App\Listeners\LogUserActivity::class, 'handle']
        );

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            // Website Settings (Global)
            $websiteSettings = \Illuminate\Support\Facades\Cache::remember('website_settings_global', 60, function () {
                return \App\Models\WebsiteSetting::get();
            });
            $view->with('website_settings', $websiteSettings);

            // Legacy Settings (Key-Value)
            $settings = \Illuminate\Support\Facades\Cache::remember('site_settings', 60, function () {
                return \App\Models\Setting::all()->pluck('value', 'key');
            });

            // Prioritize WebsiteSetting model, fallback to legacy Setting model or config
            $view->with('site_name', $websiteSettings->site_name ?? $settings['site_name'] ?? config('app.name'));
            $view->with('site_description', $settings['site_description'] ?? 'Perpustakaan Digital Kementerian Agama RI');
            $view->with('site_logo', $websiteSettings->logo ?? $settings['site_logo'] ?? null);
            $view->with('site_favicon', $websiteSettings->favicon ?? $settings['site_favicon'] ?? null);

            // Navigation menus (cached for 60 minutes)
            $navMenus = \Illuminate\Support\Facades\Cache::remember('navigation_menus', 60, function () {
                return \App\Models\NavigationMenu::root()
                    ->active()
                    ->with(['activeChildren.activeChildren'])
                    ->orderBy('order')
                    ->get();
            });
            $view->with('navigation_menus', $navMenus);



            // Contact Info (Global)
            $contactInfo = \Illuminate\Support\Facades\Cache::remember('contact_info_global', 60, function () {
                return \App\Models\ContactInfo::first();
            });
            $view->with('contactInfo', $contactInfo);

        });
    }
}
