<?php

namespace Src\Recycling\Challenge\Domain\Enumerations;

enum ChallengeType: string
{
    case WEEKLY  = 'WEEKLY';
    case MONTHLY = 'MONTHLY';
    case SPECIAL = 'SPECIAL';

    public function label(): string
    {
        return match($this) {
            self::WEEKLY  => 'Semanal',
            self::MONTHLY => 'Mensual',
            self::SPECIAL => 'Especial',
        };
    }

    public function emoji(): string
    {
        return match($this) {
            self::WEEKLY  => '📅',
            self::MONTHLY => '🗓️',
            self::SPECIAL => '⚡',
        };
    }
}