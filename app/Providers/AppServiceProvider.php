<?php

namespace App\Providers;

use App\Models\SettingSystem;
use Illuminate\Pagination\Paginator;
use Barryvdh\Debugbar\Facades\Debugbar;
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
        view()->composer('*', function ($view) {
            $view->with('setting_system', SettingSystem::pluck('value', 'key')->toArray());
        });

        Debugbar::disable();

        Paginator::useBootstrap();
    }
}
