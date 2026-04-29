<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;

/**
 * Determina qué rango corresponde a una cantidad de puntos dada.
 * Encapsula la lógica de negocio de resolución de rangos.
 */
class ResolveRankByPointsUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(int $totalPoints): Rank
    {
        return $this->repository->resolveByPoints($totalPoints);
    }
}
