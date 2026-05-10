<?php

namespace Src\Recycling\Rank\Application\Ports;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;

interface RankRepositoryPort
{
    public function create(Rank $rank): void;
    public function read(RankId $id): ?Rank;
    public function update(Rank $rank): void;
    public function delete(RankId $id): void;

    public function getAllRanks(): array;

    public function findByName(string $name): ?Rank;

    public function resolveByPoints(int $totalPoints): Rank;

    public function getNextRank(string $currentRankName): ?Rank;
}