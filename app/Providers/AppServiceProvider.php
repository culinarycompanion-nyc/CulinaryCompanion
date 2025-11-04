<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

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
        //
        URL::forceScheme('https');
        File::chmod(storage_path(), 0775);
        File::chmod(storage_path('logs'), 0775);
        File::chmod(base_path('bootstrap/cache'), 0775);
        File::chmod(storage_path('framework/views'), 0775);
        File::chmod(base_path('bootstrap/cache'), 0775);
    }
}
