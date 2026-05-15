<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Src\Recycling\Challenge\Domain\Entities\Challenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Infraestructure\Hydrators\ChallengeHydrator;
use Src\Recycling\Challenge\Infraestructure\Models\ChallengeModel;

trait ReadChallengeTrait
{
    public function read(ChallengeId $id): ?Challenge
    {
        $m = ChallengeModel::find($id->value());
        return $m ? ChallengeHydrator::toDomain($m) : null;
    }
}
