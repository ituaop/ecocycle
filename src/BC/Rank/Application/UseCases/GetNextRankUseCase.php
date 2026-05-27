<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;

class GetNextRankUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(string $currentRankName): ?Rank
    {
        return $this->repository->getNextRank($currentRankName);
    }
}