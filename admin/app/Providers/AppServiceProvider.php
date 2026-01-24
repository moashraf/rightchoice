<?php

namespace App\Providers;

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
        //
        date_default_timezone_set('Africa/Cairo');

        // Register flash notification views
        $this->loadViewsFrom(resource_path('views/vendor/flash'), 'flash');

        // Register adminlte-templates views
        $this->loadViewsFrom(resource_path('views/vendor/adminlte-templates'), 'adminlte-templates');

    }
}
