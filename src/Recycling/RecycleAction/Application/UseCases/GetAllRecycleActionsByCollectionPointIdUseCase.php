<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;

class GetAllRecycleActionsByCollectionPointIdUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(string $collectionPointId, int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getAllByCollectionPointId($collectionPointId, $page, $perPage);
    }
}
