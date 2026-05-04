<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;

class GetAllRecycleActionsByUserIdUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(string $userId, string $order = 'date', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        return $this->repository->getAllByUserId($userId, $order, $direction, $page, $perPage);
    }
}
