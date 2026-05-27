<?php

namespace Src\Recycling\WasteItem\Domain\Enumerations;

enum WasteItemCategoryEnumeration: string
{
    case PLASTIC   = 'PLASTIC';
    case GLASS     = 'GLASS';
    case PAPER     = 'PAPER';
    case METAL     = 'METAL';
    case ORGANIC   = 'ORGANIC';
    case ELECTRONIC = 'ELECTRONIC';
    case OTHER     = 'OTHER';
}
