<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Css;

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
        FilamentAsset::register([
    Css::make('custom-stylesheet', __DIR__ . '/../../resources/css/custom.css'),
]);
    }
}
