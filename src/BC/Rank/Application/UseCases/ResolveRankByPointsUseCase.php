<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;


class ResolveRankByPointsUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(int $totalPoints): Rank
    {
        return $this->repository->resolveByPoints($totalPoints);
    }
}
