<?php

namespace Src\Recycling\Challenge\Application\UseCases;

use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;

class GetActiveChallengesUseCase
{
    public function __construct(private ChallengeRepositoryPort $repository) {}

    public function execute(): array
    {
        return $this->repository->getActiveChallenges();
    }
}
