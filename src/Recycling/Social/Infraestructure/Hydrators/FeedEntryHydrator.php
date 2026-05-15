<?php

namespace Src\Recycling\Social\Infraestructure\Hydrators;

use Src\Recycling\Social\Domain\Entities\FeedEntry;
use Src\Recycling\Social\Domain\Enumerations\FeedEventType;
use Src\Recycling\Social\Domain\ValueObjects\FeedEntryId;
use Src\Recycling\Social\Domain\ValueObjects\FeedUserId;
use Src\Recycling\Social\Infraestructure\Models\FeedEntryModel;

class FeedEntryHydrator
{
    public static function toDomain(FeedEntryModel $m): FeedEntry
    {
        return new FeedEntry(
            new FeedEntryId($m->id),
            new FeedUserId($m->user_id),
            $m->team_id,
            FeedEventType::from($m->type),
            $m->title,
            $m->description,
            $m->emoji,
            (int) $m->points,
            $m->meta ?? [],
            $m->created_at,
        );
    }
}
