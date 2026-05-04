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

    /** Devuelve todos los rangos ordenados por su campo 'order' ASC. */
    public function getAllRanks(): array;

    /** Busca el rango por su nombre único (BEGINNER, EXPERT…). */
    public function findByName(string $name): ?Rank;

    /** Devuelve el rango que corresponde a los puntos dados. */
    public function resolveByPoints(int $totalPoints): Rank;

    /** Devuelve el rango siguiente al dado, o null si es el máximo. */
    public function getNextRank(string $currentRankName): ?Rank;
}