<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;

class GetAllWasteItemsUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(string $order = 'name', string $direction = 'asc', int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getAllWasteItems($order, $direction, $page, $perPage);
    }
}
