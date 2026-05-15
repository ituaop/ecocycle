<?php

namespace Src\Recycling\Challenge\Application\UseCases;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

class ClaimChallengeRewardUseCase
{
    public function __construct(private ChallengeRepositoryPort $repository) {}

    public function execute(string $userId, string $userChallengeId): int
    {
        $uc = $this->repository->readUserChallenge(new UserChallengeId($userChallengeId));

        if (!$uc) {
            throw new Exception("Participación no encontrada.");
        }
        if ($uc->getUserIdValue() !== $userId) {
            throw new Exception("No autorizado.");
        }
        if (!$uc->isCompleted()) {
            throw new Exception("El reto no está completado aún.");
        }
        if ($uc->isRewardClaimed()) {
            throw new Exception("La recompensa ya fue reclamada.");
        }

        $challenge = $this->repository->read($uc->getChallengeId());
        $bonus     = $challenge->getBonusPointsInt();

        // Suma puntos al usuario
        DB::table('recycling_users')
            ->where('id', $userId)
            ->increment('total_points', $bonus);

        // Marca como reclamada
        $claimed = new UserChallenge(
            $uc->getId(),
            $uc->getUserId(),
            $uc->getChallengeId(),
            $uc->getCurrentValue(),
            true,
            $uc->getCompletedAt(),
            true,
        );

        $this->repository->updateUserChallenge($claimed);

        return $bonus;
    }
}
