<?php

namespace Src\Recycling\Social\Application\Ports;

use Src\Recycling\Social\Domain\Entities\FeedEntry;
use Src\Recycling\Social\Domain\Entities\Team;
use Src\Recycling\Social\Domain\Entities\TeamMember;
use Src\Recycling\Social\Domain\ValueObjects\FeedEntryId;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;

interface SocialRepositoryPort
{
    public function createTeam(Team $team): void;
    public function findTeamById(TeamId $id): ?Team;
    public function findTeamBySlug(string $slug): ?Team;
    public function getPublicTeams(int $limit = 20): array;
    public function getUserTeams(string $userId): array;
    public function updateTeamPoints(TeamId $id, int $points): void;
    public function deleteTeam(TeamId $id): void;



    
    public function addMember(TeamMember $member): void;
    public function removeMember(TeamId $teamId, string $userId): void;
    public function getTeamMembers(TeamId $teamId): array;
    public function findMembership(TeamId $teamId, string $userId): ?TeamMember;
    public function countMembers(TeamId $teamId): int;



    public function createFeedEntry(FeedEntry $entry): void;
    public function getTeamFeed(TeamId $teamId, int $limit = 30): array;
    public function getGlobalFeed(string $userId, int $limit = 30): array;
    public function deleteFeedEntry(FeedEntryId $id): void;
}
