<?php


namespace Fncong\LaravelInitial;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Fncong\LaravelInitial\Console\InitCommand::class,
                \Fncong\LaravelInitial\Console\GeneratorCommand::class,
            ]);
        }
    }


    /**
     * Register the provider.
     */
    public function register()
    {

    }

}
