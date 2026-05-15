<?php

namespace Src\Recycling\Challenge\Application\UseCases;

use Exception;
use Illuminate\Support\Str;
use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeCurrentValue;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

class JoinChallengeUseCase
{
    public function __construct(private ChallengeRepositoryPort $repository) {}

    public function execute(string $userId, string $challengeId): UserChallenge
    {
        $cId    = new ChallengeId($challengeId);
        $uId    = new UserChallengeUserId($userId);

        $challenge = $this->repository->read($cId);
        if (!$challenge) {
            throw new Exception("Reto no encontrado.");
        }
        if ($challenge->isExpired()) {
            throw new Exception("Este reto ya ha finalizado.");
        }

        $existing = $this->repository->findUserChallenge($uId, $cId);
        if ($existing) {
            throw new Exception("Ya estás participando en este reto.");
        }

        $userChallenge = new UserChallenge(
            new UserChallengeId(Str::uuid()->toString()),
            $uId,
            $cId,
            new UserChallengeCurrentValue(0),
            false,
            null,
            false,
        );

        $this->repository->createUserChallenge($userChallenge);

        return $userChallenge;
    }
}
