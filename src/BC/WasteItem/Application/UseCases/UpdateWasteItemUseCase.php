<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Exception;
use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemCategory;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemDescription;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemName;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemPoints;

class UpdateWasteItemUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(CreateWasteItemDTO $dto): WasteItem
    {
        $id = new WasteItemId($dto->getId());

        if (!$this->repository->read($id)) {
            throw new Exception("No se puede actualizar: el WasteItem no existe.");
        }

        $item = new WasteItem(
            $id,
            new WasteItemName($dto->getName()),
            new WasteItemDescription($dto->getDescription()),
            new WasteItemCategory($dto->getCategory()),
            new WasteItemPoints($dto->getPoints())
        );

        $this->repository->update($item);

        return $item;
    }
}
