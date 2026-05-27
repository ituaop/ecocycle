<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;

class GetActiveCollectionPointsUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(): array
    {
        return $this->repository->getActiveCollectionPoints();
    }
}
