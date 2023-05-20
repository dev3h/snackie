<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // $locale = session('locale', config('app.locale'));
        // app()->setLocale($locale);
        app()->setLocale('vi');
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

    }
}
