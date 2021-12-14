<?php

namespace App\Providers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcuCache;
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
        $this->app->bind('App\Interfaces\Repositories\IUserRepository', 'App\Repositories\DbUserRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Doctrine\Common\Annotations\Reader', function($app) {
            $reader = new CachedReader(new AnnotationReader(), new ApcuCache());
            return $reader;
        });
    }
}
