<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
  
        $this->app->register(
            \Src\BC\Rank\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\BC\User\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\BC\User\Infraestructure\Services\AuthDependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\BC\CollectionPoint\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\BC\WasteItem\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\BC\RecycleAction\Infraestructure\Services\DependencyInversionServices::class
        );

        
    }

    public function boot(): void {}
}
