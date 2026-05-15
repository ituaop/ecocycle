<?php

namespace Src\Recycling\Social\Domain\Enumerations;

enum TeamMemberRole: string
{
    case OWNER  = 'OWNER';
    case MEMBER = 'MEMBER';

    public function label(): string
    {
        return match($this) {
            self::OWNER  => 'Fundador',
            self::MEMBER => 'Miembro',
        };
    }
}