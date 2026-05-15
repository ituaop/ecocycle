<?php

namespace Src\Recycling\Social\Application\UseCases;

use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;

class GetPublicTeamsUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(int $limit = 20): array
    {
        return $this->repository->getPublicTeams($limit);
    }
}
