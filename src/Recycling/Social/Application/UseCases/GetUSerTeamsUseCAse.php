<?php

namespace Src\Recycling\Social\Application\UseCases;

use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;

class GetUserTeamsUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(string $userId): array
    {
        return $this->repository->getUserTeams($userId);
    }
}
