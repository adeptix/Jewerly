<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config("app.is_secure")) {
            \URL::forceScheme('https');
        }
    }
}
