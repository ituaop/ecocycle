<?php

namespace Src\Recycling\Rank\Application\Services;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;

/**
 * Servicio de aplicación para resolver rangos.
 * Usa el puerto DDD en lugar de acceder directamente al modelo Eloquent.
 * Mantiene caché en memoria para evitar múltiples queries en el mismo request.
 */
class RankResolverService
{
    /** @var Rank[]|null */
    private ?array $cachedRanks = null;

    public function __construct(private RankRepositoryPort $repository) {}

    // ── Caché ────────────────────────────────────────────────────────────

    /** @return Rank[] */
    private function getRanks(): array
    {
        if ($this->cachedRanks === null) {
            $this->cachedRanks = $this->repository->getAllRanks();
        }
        return $this->cachedRanks;
    }

    // ── Métodos públicos ─────────────────────────────────────────────────

    /**
     * Devuelve el nombre del rango (BEGINNER, INTERMEDIATE…) para los puntos dados.
     */
    public function resolveLevel(int $totalPoints): string
    {
        return $this->repository->resolveByPoints($totalPoints)->getNameValue();
    }

    /**
     * Devuelve la entidad Rank completa para los puntos dados.
     */
    public function resolveRank(int $totalPoints): Rank
    {
        return $this->repository->resolveByPoints($totalPoints);
    }

    /**
     * Devuelve todos los rangos como array plano serializable para Inertia/JSON.
     */
    public function getAllRanks(): array
    {
        return array_map(
            fn(Rank $r) => $r->toArray(),
            $this->getRanks()
        );
    }

    /**
     * Devuelve la entidad del rango siguiente al actual, o null si es el máximo.
     */
    public function getNextRankEntity(string $currentLevel): ?Rank
    {
        return $this->repository->getNextRank($currentLevel);
    }

    /**
     * Devuelve el rango siguiente como array plano, o null si es el máximo.
     */
    public function getNextRank(string $currentLevel): ?array
    {
        $next = $this->repository->getNextRank($currentLevel);
        return $next?->toArray();
    }

    /**
     * Cuántos puntos faltan para subir al siguiente rango.
     * Devuelve null si ya está en el rango máximo.
     */
    public function pointsToNextRank(int $totalPoints, string $currentLevel): ?int
    {
        $next = $this->repository->getNextRank($currentLevel);
        if (!$next) {
            return null;
        }
        return max(0, $next->getMinPointsValue() - $totalPoints);
    }

    /**
     * Porcentaje de progreso dentro del rango actual (0–100).
     */
    public function progressInCurrentRank(int $totalPoints, string $currentLevel): int
    {
        $current = $this->repository->findByName($currentLevel);
        if (!$current) {
            return 0;
        }
        return $current->progressPercent($totalPoints);
    }

    /**
     * Resumen completo del estado de rango del usuario.
     * Útil para pasar de una sola vez a las vistas Inertia.
     */
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
