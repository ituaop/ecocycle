<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Infraestructure\Hydrators\RankHydrator;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait ResolveRankByPointsTrait
{
    /**
     * Devuelve la entidad Rank que corresponde a los puntos dados.
     * Itera en orden ascendente y devuelve el último que cumpla la condición.
     */
    public function resolveByPoints(int $totalPoints): Rank
    {
        $ranks = RankModel::orderBy('order')->get();

        $resolved = $ranks->first(); // fallback: rango más bajo

        foreach ($ranks as $model) {
            if ($totalPoints >= $model->min_points) {
                // max_points === 0 significa sin límite superior
                if ($model->max_points === 0 || $totalPoints <= $model->max_points) {
                    $resolved = $model;
                }
            }
        }

        return RankHydrator::toDomain($resolved);
    }

    /**
     * Devuelve el rango siguiente al actual, o null si es el máximo.
     */
    public function getNextRank(string $currentRankName): ?Rank
    {
        $ranks = RankModel::orderBy('order')->get();

        $found = false;
        foreach ($ranks as $model) {
            if ($found) {
                return RankHydrator::toDomain($model);
            }
            if (strtoupper($model->name) === strtoupper($currentRankName)) {
                $found = true;
            }
        }

        return null; // ya es el rango máximo
    }
}
