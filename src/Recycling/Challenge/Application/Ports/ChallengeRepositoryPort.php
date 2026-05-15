<?php

namespace Src\Recycling\Challenge\Application\Ports;

use Src\Recycling\Challenge\Domain\Entities\Challenge;
use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

interface ChallengeRepositoryPort
{
    // Challenges
    public function create(Challenge $challenge): void;
    public function read(ChallengeId $id): ?Challenge;
    public function getActiveChallenges(): array;

    // UserChallenges
    public function createUserChallenge(UserChallenge $userChallenge): void;
    public function updateUserChallenge(UserChallenge $userChallenge): void;
    public function findUserChallenge(UserChallengeUserId $userId, ChallengeId $challengeId): ?UserChallenge;
    public function getUserChallenges(UserChallengeUserId $userId): array;
    public function readUserChallenge(UserChallengeId $id): ?UserChallenge;
}


