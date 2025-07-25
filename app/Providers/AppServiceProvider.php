<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;

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
        // Set the default string length for database columns to avoid issues with older MySQL versions.
        Schema::defaultStringLength(128);
        Passport::tokensCan([
            'user:all' => 'Admin permissions',
            'user:read' => 'User permissions'
        ]);
    }
}
