<?php

namespace Src\Recycling\Social\Application\UseCases;

use Exception;
use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;

class LeaveTeamUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(string $userId, string $teamId): void
    {
        $tId       = new TeamId($teamId);
        $membership = $this->repository->findMembership($tId, $userId);

        if (!$membership) {
            throw new Exception("No eres miembro de este equipo.");
        }

        if ($membership->isOwner()) {
            throw new Exception("El fundador no puede abandonar el equipo. Transfiere la propiedad primero o elimina el equipo.");
        }

        $this->repository->removeMember($tId, $userId);
    }
}


