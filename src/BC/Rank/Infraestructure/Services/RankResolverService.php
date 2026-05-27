<?php

namespace Src\Recycling\Rank\Application\Services;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;

class RankResolverService
{
    /** @var Rank[]|null */
    private ?array $cachedRanks = null;

    public function __construct(private RankRepositoryPort $repository) {}


    private function getRanks(): array
    {
        if ($this->cachedRanks === null) {
            $this->cachedRanks = $this->repository->getAllRanks();
        }
        return $this->cachedRanks;
    }


    public function resolveLevel(int $totalPoints): string
    {
        return $this->repository->resolveByPoints($totalPoints)->getNameValue();
    }

    public function resolveRank(int $totalPoints): Rank
    {
        return $this->repository->resolveByPoints($totalPoints);
    }

    
    public function getAllRanks(): array
    {
        return array_map(
            fn(Rank $r) => $r->toArray(),
            $this->getRanks()
        );
    }


    public function getNextRankEntity(string $currentLevel): ?Rank
    {
        return $this->repository->getNextRank($currentLevel);
    }


    public function getNextRank(string $currentLevel): ?array
    {
        $next = $this->repository->getNextRank($currentLevel);
        return $next?->toArray();
    }

    public function pointsToNextRank(int $totalPoints, string $currentLevel): ?int
    {
        $next = $this->repository->getNextRank($currentLevel);
        if (!$next) {
            return null;
        }
        return max(0, $next->getMinPointsValue() - $totalPoints);
    }

    public function progressInCurrentRank(int $totalPoints, string $currentLevel): int
    {
        $current = $this->repository->findByName($currentLevel);
        if (!$current) {
            return 0;
        }
        return $current->progressPercent($totalPoints);
    }


    public function getRankSummary(int $totalPoints, string $currentLevel): array
    {
        $current  = $this->repository->findByName($currentLevel);
        $next     = $this->repository->getNextRank($currentLevel);
        $progress = $current ? $current->progressPercent($totalPoints) : 0;

        return [
            'allRanks'     => $this->getAllRanks(),
            'currentRank'  => $current?->toArray(),
            'nextRank'     => $next?->toArray(),
            'progress'     => $progress,
            'pointsToNext' => $next ? max(0, $next->getMinPointsValue() - $totalPoints) : null,
        ];
    }
}
