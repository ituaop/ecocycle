<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;

class GetAllCollectionPointsUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(string $order = 'name', string $direction = 'asc', int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getAllCollectionPoints($order, $direction, $page, $perPage);
    }
}
