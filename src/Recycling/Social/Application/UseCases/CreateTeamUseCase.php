<?php

namespace Src\Recycling\Social\Application\UseCases;

use Exception;
use Illuminate\Support\Str;
use Src\Recycling\Social\Application\DTOs\CreateTeamDTO;
use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Domain\Entities\Team;
use Src\Recycling\Social\Domain\Entities\TeamMember;
use Src\Recycling\Social\Domain\Enumerations\TeamMemberRole;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamMemberId;
use Src\Recycling\Social\Domain\ValueObjects\TeamName;
use Src\Recycling\Social\Domain\ValueObjects\TeamOwnerId;
use Src\Recycling\Social\Domain\ValueObjects\TeamSlug;

class CreateTeamUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(CreateTeamDTO $dto): Team
    {
        // Slug único
        $baseSlug = Str::slug($dto->getName());
        $slug     = $baseSlug;
        $i        = 1;
        while ($this->repository->findTeamBySlug($slug)) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        $team = new Team(
            new TeamId($dto->getId() ?? Str::uuid()->toString()),
            new TeamName($dto->getName()),
            new TeamSlug($slug),
            $dto->getDescription(),
            $dto->getEmoji(),
            $dto->getBadgeColor(),
            new TeamOwnerId($dto->getOwnerId()),
            $dto->getIsPublic(),
            $dto->getMaxMembers(),
            0,
        );

        $this->repository->createTeam($team);

        // El creador entra automáticamente como OWNER
        $this->repository->addMember(new TeamMember(
            new TeamMemberId(Str::uuid()->toString()),
            $team->getId(),
            $dto->getOwnerId(),
            TeamMemberRole::OWNER,
            now(),
        ));

        return $team;
    }
}
