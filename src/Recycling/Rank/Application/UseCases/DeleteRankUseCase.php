<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Exception;
use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;

class DeleteRankUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(int $id): void
    {
        $rankId = new RankId($id);

        if (!$this->repository->read($rankId)) {
            throw new Exception("Rango con ID {$id} no encontrado.");
        }

        $this->repository->delete($rankId);
    }
}

