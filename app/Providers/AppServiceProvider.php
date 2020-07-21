<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

     // if you get the error key users table 
    public function boot()
    {
        Schema::defaultStringLength(191);
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        if (env('APP_ENV') === 'local') {
          $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     * 
     */
    public function register()
    {
        //
    }
}
