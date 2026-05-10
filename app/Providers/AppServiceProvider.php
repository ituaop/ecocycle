<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
  
        $this->app->register(
            \Src\Recycling\Rank\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\Recycling\User\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\Recycling\User\Infraestructure\Services\AuthDependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\Recycling\CollectionPoint\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\Recycling\WasteItem\Infraestructure\Services\DependencyInversionServices::class
        );

        
        $this->app->register(
            \Src\Recycling\RecycleAction\Infraestructure\Services\DependencyInversionServices::class
        );
    }

    public function boot(): void {}
}
