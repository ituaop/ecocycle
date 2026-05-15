<?php

namespace Src\Recycling\Social\Domain\Entities;

use Carbon\Carbon;
use Src\Recycling\Social\Domain\Enumerations\TeamMemberRole;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamMemberId;

class TeamMember
{
    public function __construct(
        private TeamMemberId    $id,
        private TeamId          $teamId,
        private string          $userId,
        private TeamMemberRole  $role,
        private ?Carbon         $joinedAt,
    ) {}

    public function getId(): TeamMemberId       { return $this->id; }
    public function getTeamId(): TeamId         { return $this->teamId; }
    public function getUserId(): string         { return $this->userId; }
    public function getRole(): TeamMemberRole   { return $this->role; }
    public function getJoinedAt(): ?Carbon      { return $this->joinedAt; }

    public function getIdValue(): string     { return $this->id->value(); }
    public function getTeamIdValue(): string { return $this->teamId->value(); }
    public function getRoleValue(): string   { return $this->role->value; }
    public function isOwner(): bool          { return $this->role === TeamMemberRole::OWNER; }
}

