<?php

namespace Src\Recycling\Social\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Infraestructure\Repositories\EloquentSocialRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SocialRepositoryPort::class,
            EloquentSocialRepository::class
        );
    }
}
