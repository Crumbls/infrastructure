<?php

namespace Crumbls\Infrastructure;

use Illuminate\Support\ServiceProvider;

class InfrastructureServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'infrastructure');

        $this->publishes([
            __DIR__ . '/../config/infrastructure.php' => config_path('infrastructure.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/infrastructure'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/infrastructure.php', 'infrastructure');
    }
}
