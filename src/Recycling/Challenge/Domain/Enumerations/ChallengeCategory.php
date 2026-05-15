<?php

namespace Src\Recycling\Challenge\Domain\Enumerations;

enum ChallengeCategory: string
{
    case QUANTITY = 'QUANTITY'; // Recicla N veces
    case VARIETY  = 'VARIETY';  // Recicla N materiales distintos
    case STREAK   = 'STREAK';   // Recicla N días seguidos
    case POINTS   = 'POINTS';   // Acumula N puntos

    public function label(): string
    {
        return match($this) {
            self::QUANTITY => 'Cantidad',
            self::VARIETY  => 'Variedad',
            self::STREAK   => 'Racha',
            self::POINTS   => 'Puntos',
        };
    }

    public function description(int $target): string
    {
        return match($this) {
            self::QUANTITY => "Recicla {$target} veces",
            self::VARIETY  => "Recicla {$target} materiales distintos",
            self::STREAK   => "Recicla {$target} días seguidos",
            self::POINTS   => "Acumula {$target} puntos",
        };
    }
}
