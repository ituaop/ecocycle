<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;

class GetAllRanksUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    /** @return \Src\Recycling\Rank\Domain\Entities\Rank[] */
    public function execute(): array
    {
        return $this->repository->getAllRanks();
    }
}
