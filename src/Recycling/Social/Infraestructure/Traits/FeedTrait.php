<?php

namespace Src\Recycling\Social\Infraestructure\Traits;

use Illuminate\Support\Facades\DB;
use Src\Recycling\Social\Domain\Entities\FeedEntry;
use Src\Recycling\Social\Domain\ValueObjects\FeedEntryId;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Infraestructure\Hydrators\FeedEntryHydrator;
use Src\Recycling\Social\Infraestructure\Models\FeedEntryModel;

trait FeedTrait
{
    public function createFeedEntry(FeedEntry $e): void
    {
        FeedEntryModel::create([
            'id'          => $e->getIdValue(),
            'user_id'     => $e->getUserIdValue(),
            'team_id'     => $e->getTeamId(),
            'type'        => $e->getTypeValue(),
            'title'       => $e->getTitle(),
            'description' => $e->getDescription(),
            'emoji'       => $e->getEmoji(),
            'points'      => $e->getPoints(),
            'meta'        => $e->getMeta(),
        ]);
    }

    public function getTeamFeed(TeamId $teamId, int $limit = 30): array
    {
        return FeedEntryModel::where('team_id', $teamId->value())
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn($m) => FeedEntryHydrator::toDomain($m))
            ->all();
    }

    public function getGlobalFeed(string $userId, int $limit = 30): array
    {
        // Feed de los equipos del usuario + sus propias acciones
        $teamIds = DB::table('team_members')
            ->where('user_id', $userId)
            ->pluck('team_id')
            ->toArray();

        return FeedEntryModel::where(function ($q) use ($userId, $teamIds) {
            $q->where('user_id', $userId)
              ->orWhereIn('team_id', $teamIds);
        })
        ->latest()
        ->limit($limit)
        ->get()
        ->map(fn($m) => FeedEntryHydrator::toDomain($m))
        ->all();
    }

    public function deleteFeedEntry(FeedEntryId $id): void
    {
        FeedEntryModel::find($id->value())?->delete();
    }
}
