<?php

namespace Src\Recycling\CollectionPoint\Domain\Enumerations;

enum CollectionPointStatusEnumeration: string
{
    case ACTIVE   = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case FULL     = 'FULL';
}