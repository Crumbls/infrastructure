<?php

namespace Crumbls\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfrastructureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services and configurations for the Infrastructure package.
     *
     * Performs several key setup tasks:
     * - Loads database migrations
     * - Registers package views
     * - Publishes configuration and view files
     * - Registers Filament components and resources (if Filament exists)
     */
    public function boot()
    {
        // Load package migrations from the specified directory
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Register package views with 'infrastructure' namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'infrastructure');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'infrastructure');

        // Define publishable assets for the package
        $this->publishes([
            // Publish configuration file
            __DIR__ . '/../config/infrastructure.php' => config_path('infrastructure.php'),
            // Publish views to vendor directory
            __DIR__ . '/../resources/views' => resource_path('views/vendor/infrastructure'),
        ]);

        // Check if Filament is installed before registering Filament-specific components
        if (class_exists(\Filament\Resources\Resource::class)) {
            // Register Livewire components for Infrastructure pages
            Livewire::component('crumbls.infrastructure.filament.resources.pages.infrastructure-map', \Crumbls\Infrastructure\Filament\Resources\Pages\InfrastructureMap::class);
            Livewire::component('crumbls.infrastructure.filament.resources.pages.list-nodes', \Crumbls\Infrastructure\Filament\Resources\Pages\ListNodes::class);
            Livewire::component('crumbls.infrastructure.filament.resources.pages.create-node', \Crumbls\Infrastructure\Filament\Resources\Pages\CreateNode::class);
            Livewire::component('crumbls.infrastructure.filament.resources.pages.edit-node', \Crumbls\Infrastructure\Filament\Resources\Pages\EditNode::class);
            Livewire::component('crumbls.infrastructure.filament.resources.pages.view-node', \Crumbls\Infrastructure\Filament\Resources\Pages\ViewNode::class);

            // Register Filament resources and pages when Filament is resolved
            $this->app->resolving('filament', function () {
                // Register NodeResource for Filament admin panel
                \Filament\Facades\Filament::registerResources([
                    \Crumbls\Infrastructure\Filament\Resources\NodeResource::class,
                ]);

                // Register Infrastructure Map page
                \Filament\Facades\Filament::registerPages([
                    \Crumbls\Infrastructure\Filament\Resources\Pages\InfrastructureMap::class,
                ]);
            });
        }
    }

    /**
     * Register package configuration.
     *
     * Merges package configuration with application configuration.
     */
    public function register()
    {
        // Merge package config with application config
        $this->mergeConfigFrom(__DIR__ . '/../config/infrastructure.php', 'infrastructure');
    }
}
