<?php

namespace Src\Recycling\Challenge\Application\UseCases;

use Carbon\Carbon;
use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeCurrentValue;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

class UpdateChallengeProgressUseCase
{
    public function __construct(private ChallengeRepositoryPort $repository) {}

    /**
     * Incrementa el progreso del usuario en todos sus retos activos.
     * $increment es el valor a sumar (1 acción, N puntos, etc.)
     * Devuelve array de UserChallenges recién completados para notificar al usuario.
     */
    public function execute(string $userId, int $increment = 1): array
    {
        $uId            = new UserChallengeUserId($userId);
        $userChallenges = $this->repository->getUserChallenges($uId);
        $justCompleted  = [];

        foreach ($userChallenges as $uc) {
            /** @var UserChallenge $uc */
            if ($uc->isCompleted()) continue;

            $challenge = $this->repository->read($uc->getChallengeId());
            if (!$challenge || $challenge->isExpired()) continue;

            $newValue = $uc->getCurrentValueInt() + $increment;
            $target   = $challenge->getTargetValueInt();
            $done     = $newValue >= $target;

            $updated = new UserChallenge(
                $uc->getId(),
                $uc->getUserId(),
                $uc->getChallengeId(),
                new UserChallengeCurrentValue(min($newValue, $target)),
                $done,
                $done ? Carbon::now() : null,
                $uc->isRewardClaimed(),
            );

            $this->repository->updateUserChallenge($updated);

            if ($done) {
                $justCompleted[] = $updated;
            }
        }

        return $justCompleted;
    }
}
