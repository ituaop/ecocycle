<?php

namespace Src\Recycling\Rank\Domain\Entities;

use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeColor;
use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeIcon;
use Src\Recycling\Rank\Domain\ValueObjects\RankDescription;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;
use Src\Recycling\Rank\Domain\ValueObjects\RankLabel;
use Src\Recycling\Rank\Domain\ValueObjects\RankMaxPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankMinPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankName;
use Src\Recycling\Rank\Domain\ValueObjects\RankOrder;

class Rank
{
    private RankId          $id;
    private RankName        $name;
    private RankLabel       $label;
    private RankDescription $description;
    private RankBadgeColor  $badgeColor;
    private RankBadgeIcon   $badgeIcon;
    private RankMinPoints   $minPoints;
    private RankMaxPoints   $maxPoints;
    private RankOrder       $order;

    public function __construct(
        RankId          $id,
        RankName        $name,
        RankLabel       $label,
        RankDescription $description,
        RankBadgeColor  $badgeColor,
        RankBadgeIcon   $badgeIcon,
        RankMinPoints   $minPoints,
        RankMaxPoints   $maxPoints,
        RankOrder       $order
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->label       = $label;
        $this->description = $description;
        $this->badgeColor  = $badgeColor;
        $this->badgeIcon   = $badgeIcon;
        $this->minPoints   = $minPoints;
        $this->maxPoints   = $maxPoints;
        $this->order       = $order;
    }

    // ── Getters ─────────────────────────────────────────────────────────

    public function getId(): RankId               { return $this->id; }
    public function getIdValue(): int             { return $this->id->value(); }

    public function getName(): RankName           { return $this->name; }
    public function getNameValue(): string        { return $this->name->value(); }

    public function getLabel(): RankLabel         { return $this->label; }
    public function getLabelValue(): string       { return $this->label->value(); }

    public function getDescription(): RankDescription   { return $this->description; }
    public function getDescriptionValue(): string       { return $this->description->value(); }

    public function getBadgeColor(): RankBadgeColor     { return $this->badgeColor; }
    public function getBadgeColorValue(): string        { return $this->badgeColor->value(); }

    public function getBadgeIcon(): RankBadgeIcon       { return $this->badgeIcon; }
    public function getBadgeIconValue(): string         { return $this->badgeIcon->value(); }

    public function getMinPoints(): RankMinPoints { return $this->minPoints; }
    public function getMinPointsValue(): int      { return $this->minPoints->value(); }

    public function getMaxPoints(): RankMaxPoints { return $this->maxPoints; }
    public function getMaxPointsValue(): int      { return $this->maxPoints->value(); }

    public function getOrder(): RankOrder         { return $this->order; }
    public function getOrderValue(): int          { return $this->order->value(); }

    // ── Domain logic ────────────────────────────────────────────────────

    /**
     * Devuelve true si este rango es el máximo (sin techo de puntos).
     */
    public function isMaxRank(): bool
    {
        return $this->maxPoints->isUnlimited();
    }

    /**
     * Devuelve true si los puntos dados corresponden a este rango.
     */
    public function matchesPoints(int $totalPoints): bool
    {
        if ($totalPoints < $this->minPoints->value()) {
            return false;
        }

        if ($this->maxPoints->isUnlimited()) {
            return true;
        }

        return $totalPoints <= $this->maxPoints->value();
    }

    /**
     * Cuántos puntos quedan para salir de este rango.
     * Devuelve null si es el rango máximo.
     */
    public function pointsToExit(int $currentPoints): ?int
    {
        if ($this->maxPoints->isUnlimited()) {
            return null;
        }
        return max(0, $this->maxPoints->value() - $currentPoints + 1);
    }

    /**
     * Porcentaje de progreso dentro de este rango (0–100).
     */
    public function progressPercent(int $currentPoints): int
    {
        if ($this->maxPoints->isUnlimited()) {
            return 100;
        }

        $range    = $this->maxPoints->value() - $this->minPoints->value();
        $progress = $currentPoints - $this->minPoints->value();

        if ($range <= 0) {
            return 100;
        }

        return min(100, (int) round(($progress / $range) * 100));
    }

    /**
     * Serializa la entidad a un array plano (útil para Inertia / respuestas JSON).
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->getIdValue(),
            'name'        => $this->getNameValue(),
            'label'       => $this->getLabelValue(),
            'description' => $this->getDescriptionValue(),
            'badge_color' => $this->getBadgeColorValue(),
            'badge_icon'  => $this->getBadgeIconValue(),
            'min_points'  => $this->getMinPointsValue(),
            'max_points'  => $this->getMaxPointsValue(),
            'order'       => $this->getOrderValue(),
            'is_max_rank' => $this->isMaxRank(),
        ];
    }
}