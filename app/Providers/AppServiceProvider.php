<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ── Rank (primero: RankResolverService es dependencia de otros controllers)
        $this->app->register(
            \Src\Recycling\Rank\Infraestructure\Services\DependencyInversionServices::class
        );

        // ── User - dominio general
        $this->app->register(
            \Src\Recycling\User\Infraestructure\Services\DependencyInversionServices::class
        );

        // ── User - autenticación
        $this->app->register(
            \Src\Recycling\User\Infraestructure\Services\DependencyInversionServices::class
        );

        // ── CollectionPoint
        $this->app->register(
            \Src\Recycling\CollectionPoint\Infraestructure\Services\DependencyInversionServices::class
        );

        // ── WasteItem
        $this->app->register(
            \Src\Recycling\WasteItem\Infraestructure\Services\DependencyInversionServices::class
        );

        // ── RecycleAction
        $this->app->register(
            \Src\Recycling\RecycleAction\Infraestructure\Services\DependencyInversionServices::class
        );
    }

    public function boot(): void {}
}
