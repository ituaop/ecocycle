<?php

namespace Src\Recycling\User\Application\UseCases;

use Src\Recycling\User\Application\Ports\UserRepositoryPort;

class GetAllUsersUseCase
{
    public function __construct(private UserRepositoryPort $repository) {}

    public function execute(
        string $order     = 'name',
        string $direction = 'asc',
        int    $page      = 1,
        int    $perPage   = 10
    ): array {
        return $this->repository->getAllUsers($order, $direction, $page, $perPage);
    }
}
