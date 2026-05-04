<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Exception;
use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;

class ReadRankUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(int $id): Rank
    {
        $rank = $this->repository->read(new RankId($id));

        if (!$rank) {
            throw new Exception("Rango con ID {$id} no encontrado.");
        }

        return $rank;
    }
}

