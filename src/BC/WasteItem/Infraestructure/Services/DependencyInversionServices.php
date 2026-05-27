<?php

namespace Src\Recycling\WasteItem\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Infraestructure\Repositories\EloquentWasteItemRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            WasteItemRepositoryPort::class,
            EloquentWasteItemRepository::class
        );
    }
}
