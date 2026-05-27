<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Illuminate\Support\Str;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;
use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAcceptedCategories;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAddress;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLatitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLongitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointName;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointSchedule;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointStatus;

class CreateCollectionPointUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(CreateCollectionPointDTO $dto): CollectionPoint
    {
        $cp = new CollectionPoint(
            new CollectionPointId($dto->getId() ?? Str::uuid()->toString()),
            new CollectionPointName($dto->getName()),
            new CollectionPointAddress($dto->getAddress()),
            new CollectionPointLatitude($dto->getLatitude()),
            new CollectionPointLongitude($dto->getLongitude()),
            new CollectionPointStatus($dto->getStatus()),
            new CollectionPointSchedule($dto->getSchedule()),
            new CollectionPointAcceptedCategories($dto->getAcceptedCategories())
        );

        $this->repository->create($cp);

        return $cp;
    }
}
