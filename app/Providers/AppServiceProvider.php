<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        // Set locale Carbon ke bahasa Indonesia
        Carbon::setLocale('id_ID');

        // Set lokal sistem untuk fungsi date/time di PHP
        setlocale(LC_TIME, 'id_ID.utf8');
    }
}
