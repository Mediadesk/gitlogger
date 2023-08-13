<?php


namespace Mediadesk\GitLogger;

use Illuminate\Support\ServiceProvider;

class GitLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        
    }

    public function register()
    {
        $this->app->singleton('GitLogger', function($app){
            return new GitLogger;
        });
    }
}