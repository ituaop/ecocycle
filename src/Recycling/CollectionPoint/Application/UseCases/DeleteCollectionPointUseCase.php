<?php

namespace Src\Recycling\CollectionPoint\Application\UseCases;

use Exception;
use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;

class DeleteCollectionPointUseCase
{
    public function __construct(private CollectionPointRepositoryPort $repository) {}

    public function execute(string $id): void
    {
        $cpId = new CollectionPointId($id);

        if (!$this->repository->read($cpId)) {
            throw new Exception("Punto de recogida no encontrado.");
        }

        $this->repository->delete($cpId);
    }
}
