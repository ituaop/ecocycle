<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Src\Recycling\Rank\Application\DTOs\CreateRankDTO;
use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeColor;
use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeIcon;
use Src\Recycling\Rank\Domain\ValueObjects\RankDescription;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;
use Src\Recycling\Rank\Domain\ValueObjects\RankLabel;
use Src\Recycling\Rank\Domain\ValueObjects\RankMaxPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankMinPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankName;
use Src\Recycling\Rank\Domain\ValueObjects\RankOrder;

class CreateRankUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(CreateRankDTO $dto): Rank
    {
        $rank = new Rank(
            new RankId($dto->getId() ?? 0),   // 0 se ignora en auto-increment
            new RankName($dto->getName()),
            new RankLabel($dto->getLabel()),
            new RankDescription($dto->getDescription()),
            new RankBadgeColor($dto->getBadgeColor()),
            new RankBadgeIcon($dto->getBadgeIcon()),
            new RankMinPoints($dto->getMinPoints()),
            new RankMaxPoints($dto->getMaxPoints()),
            new RankOrder($dto->getOrder())
        );

        $this->repository->create($rank);

        return $rank;
    }
}

