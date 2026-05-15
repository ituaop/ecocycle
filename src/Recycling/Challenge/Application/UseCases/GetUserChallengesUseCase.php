<?php

namespace Src\Recycling\Challenge\Application\UseCases;

use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

class GetUserChallengesUseCase
{
    public function __construct(private ChallengeRepositoryPort $repository) {}

    public function execute(string $userId): array
    {
        return $this->repository->getUserChallenges(new UserChallengeUserId($userId));
    }
}
