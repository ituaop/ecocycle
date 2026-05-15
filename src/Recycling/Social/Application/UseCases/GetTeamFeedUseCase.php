<?php

namespace Src\Recycling\Social\Application\UseCases;

use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;

class GetTeamFeedUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(string $teamId, int $limit = 30): array
    {
        return $this->repository->getTeamFeed(new TeamId($teamId), $limit);
    }
}