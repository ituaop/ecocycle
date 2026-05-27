<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Exception;
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

class UpdateCollectionPointUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(CreateCollectionPointDTO $dto): CollectionPoint
    {
        $id = new CollectionPointId($dto->getId());

        if (!$this->repository->read($id)) {
            throw new Exception("No se puede actualizar: el punto de recogida no existe.");
        }

        $cp = new CollectionPoint(
            $id,
            new CollectionPointName($dto->getName()),
            new CollectionPointAddress($dto->getAddress()),
            new CollectionPointLatitude($dto->getLatitude()),
            new CollectionPointLongitude($dto->getLongitude()),
            new CollectionPointStatus($dto->getStatus()),
            new CollectionPointSchedule($dto->getSchedule()),
            new CollectionPointAcceptedCategories($dto->getAcceptedCategories())
        );

        $this->repository->update($cp);

        return $cp;
    }
}
