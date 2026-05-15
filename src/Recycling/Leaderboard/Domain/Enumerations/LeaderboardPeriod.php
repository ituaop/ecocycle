<?php

namespace Src\Recycling\Leaderboard\Domain\Enumerations;

enum LeaderboardPeriod: string
{
    case WEEKLY  = 'WEEKLY';
    case MONTHLY = 'MONTHLY';
    case ALLTIME = 'ALLTIME';

    public function label(): string
    {
        return match($this) {
            self::WEEKLY  => 'Esta semana',
            self::MONTHLY => 'Este mes',
            self::ALLTIME => 'Todo el tiempo',
        };
    }

    public function emoji(): string
    {
        return match($this) {
            self::WEEKLY  => '📅',
            self::MONTHLY => '🗓️',
            self::ALLTIME => '🏆',
        };
    }

    public function currentKey(): string
    {
        return match($this) {
            self::WEEKLY  => now()->format('Y-\WW'),
            self::MONTHLY => now()->format('Y-m'),
            self::ALLTIME => 'ALL',
        };
    }
}