<?php

namespace Src\Recycling\Social\Domain\Enumerations;

enum FeedEventType: string
{
    case RECYCLE          = 'RECYCLE';
    case LEVEL_UP         = 'LEVEL_UP';
    case CHALLENGE_DONE   = 'CHALLENGE_DONE';
    case REWARD_UNLOCKED  = 'REWARD_UNLOCKED';
    case TEAM_JOINED      = 'TEAM_JOINED';

    public function defaultEmoji(): string
    {
        return match($this) {
            self::RECYCLE         => '♻️',
            self::LEVEL_UP        => '🎉',
            self::CHALLENGE_DONE  => '🏆',
            self::REWARD_UNLOCKED => '🎁',
            self::TEAM_JOINED     => '👥',
        };
    }
}

