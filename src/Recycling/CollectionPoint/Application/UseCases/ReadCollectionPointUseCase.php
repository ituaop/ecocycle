<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Exception;
use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;
use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;

class ReadCollectionPointUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(string $id): CollectionPoint
    {
        $cp = $this->repository->read(new CollectionPointId($id));

        if (!$cp) {
            throw new Exception("Punto de recogida no encontrado.");
        }

        return $cp;
    }
}
