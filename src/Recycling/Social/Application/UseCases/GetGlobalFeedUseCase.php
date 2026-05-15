<?php

namespace Src\Recycling\Social\Application\UseCases;

use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;

class GetGlobalFeedUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(string $userId, int $limit = 30): array
    {
        return $this->repository->getGlobalFeed($userId, $limit);
    }
}
