<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;

class GetAllRecycleActionsUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(string $order = 'date', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getAllRecycleActions($order, $direction, $page, $perPage);
    }
}
