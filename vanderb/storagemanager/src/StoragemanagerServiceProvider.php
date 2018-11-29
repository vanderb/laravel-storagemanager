<?php

namespace Vanderb\Storagemanager;

use Illuminate\Support\ServiceProvider;

class StoragemanagerServiceProvider extends ServiceProvider {
    /**
     * Boot the service provider.
     */
    
    public function boot()
    {
        //Publish config and translations
        $this->publishes([
            //__DIR__.'/../resources/views' => resource_path('views/vendor/storagemanager'),

            //publish storagemanager js assets
            __DIR__.'/../dist' => public_path('vendor/laravel-storagemanager'),
        ]);

        //load routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'storagemanager');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //Merge config
        $this->mergeConfigFrom(
            __DIR__.'/config/storagemanager.php', 'storagemanager'
        );

        // Register new storage-disk
        config(['filesystems.disks.storagemanager' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage/public',
            'visibility' => 'public'
        ]]);

        //Run fixed bindings
        $this->app->bind(Contracts\StoragemanagerContract::class, Storagemanager::class);
    }
    
}
