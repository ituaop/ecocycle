<?php

namespace Src\Recycling\Rank\Domain\Enumerations;

enum RankNameEnumeration: string
{
    case BEGINNER     = 'BEGINNER';
    case INTERMEDIATE = 'INTERMEDIATE';
    case ADVANCED     = 'ADVANCED';
    case EXPERT       = 'EXPERT';
}