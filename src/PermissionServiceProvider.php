<?php

namespace JetBox\Permission;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function ($value) {
            return (auth()->check()) && (auth()->user()->hasRole($value));
        });

        Blade::if('hasRole', function ($value) {
            return (auth()->check()) && (auth()->user()->hasRole($value));
        });

        Blade::if('hasAnyRole', function ($value) {
            return (auth()->check()) && (auth()->user()->hasAnyRole($value));
        });

        Blade::if('unlessRole', function ($value) {
            return (auth()->check()) && (!auth()->user()->hasRole($value));
        });

        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations')
        ], 'permission-migrations');

        $this->loadMigrationsFrom(__DIR__ . 'database/migrations');
    }
}
