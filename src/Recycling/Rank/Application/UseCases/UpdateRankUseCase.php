<?php

namespace Src\Recycling\Rank\Application\UseCases;

use Exception;
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

class UpdateRankUseCase
{
    public function __construct(private RankRepositoryPort $repository) {}

    public function execute(CreateRankDTO $dto): Rank
    {
        $id = new RankId($dto->getId());

        if (!$this->repository->read($id)) {
            throw new Exception("No se puede actualizar: el rango con ID {$dto->getId()} no existe.");
        }

        $rank = new Rank(
            $id,
            new RankName($dto->getName()),
            new RankLabel($dto->getLabel()),
            new RankDescription($dto->getDescription()),
            new RankBadgeColor($dto->getBadgeColor()),
            new RankBadgeIcon($dto->getBadgeIcon()),
            new RankMinPoints($dto->getMinPoints()),
            new RankMaxPoints($dto->getMaxPoints()),
            new RankOrder($dto->getOrder())
        );

        $this->repository->update($rank);

        return $rank;
    }
}