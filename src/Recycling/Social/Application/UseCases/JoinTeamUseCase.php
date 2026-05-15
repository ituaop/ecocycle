<?php

namespace Src\Recycling\Social\Application\UseCases;

use Exception;
use Illuminate\Support\Str;
use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Domain\Entities\TeamMember;
use Src\Recycling\Social\Domain\Enumerations\TeamMemberRole;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamMemberId;

class JoinTeamUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(string $userId, string $teamId): TeamMember
    {
        $tId = new TeamId($teamId);
        $team = $this->repository->findTeamById($tId);

        if (!$team) {
            throw new Exception("Equipo no encontrado.");
        }

        $existing = $this->repository->findMembership($tId, $userId);
        if ($existing) {
            throw new Exception("Ya eres miembro de este equipo.");
        }

        $memberCount = $this->repository->countMembers($tId);
        if ($memberCount >= $team->getMaxMembers()) {
            throw new Exception("El equipo está lleno.");
        }

        $member = new TeamMember(
            new TeamMemberId(Str::uuid()->toString()),
            $tId,
            $userId,
            TeamMemberRole::MEMBER,
            now(),
        );

        $this->repository->addMember($member);

        return $member;
    }
}

