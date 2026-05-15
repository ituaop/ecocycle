<?php

namespace Src\Recycling\Social\Application\UseCases;

use Illuminate\Support\Str;
use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Domain\Entities\FeedEntry;
use Src\Recycling\Social\Domain\Enumerations\FeedEventType;
use Src\Recycling\Social\Domain\ValueObjects\FeedEntryId;
use Src\Recycling\Social\Domain\ValueObjects\FeedUserId;

class CreateFeedEntryUseCase
{
    public function __construct(private SocialRepositoryPort $repository) {}

    public function execute(
        string $userId,
        string $type,
        string $title,
        int    $points    = 0,
        ?string $description = null,
        ?string $teamId   = null,
        array  $meta      = [],
    ): FeedEntry {
        $eventType = FeedEventType::from($type);

        $entry = new FeedEntry(
            new FeedEntryId(Str::uuid()->toString()),
            new FeedUserId($userId),
            $teamId,
            $eventType,
            $title,
            $description,
            $eventType->defaultEmoji(),
            $points,
            $meta,
            now(),
        );

        $this->repository->createFeedEntry($entry);

        return $entry;
    }
}
