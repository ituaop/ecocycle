<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Carbon\Carbon;
use Src\Recycling\Challenge\Infraestructure\Hydrators\ChallengeHydrator;
use Src\Recycling\Challenge\Infraestructure\Models\ChallengeModel;

trait GetActiveChallengesTrait
{
    public function getActiveChallenges(): array
    {
        return ChallengeModel::where('is_active', true)
            ->where('ends_at', '>=', Carbon::today())
            ->orderBy('ends_at')
            ->get()
            ->map(fn($m) => ChallengeHydrator::toDomain($m))
            ->all();
    }
}
