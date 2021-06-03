<?php


namespace Overtrue\LaravelWeChat;

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
                FooCommand::class,
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
