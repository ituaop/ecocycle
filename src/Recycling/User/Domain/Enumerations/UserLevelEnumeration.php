<?php

namespace Src\Recycling\User\Domain\Enumerations;

enum UserLevelEnumeration: string
{
    case BEGINNER     = 'BEGINNER';
    case INTERMEDIATE = 'INTERMEDIATE';
    case ADVANCED     = 'ADVANCED';
    case EXPERT       = 'EXPERT';
}