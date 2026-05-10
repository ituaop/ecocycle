<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;

class GetAllRanksUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

   
    public function execute(): array
    {
        return $this->repository->getAllRanks();
    }
}
