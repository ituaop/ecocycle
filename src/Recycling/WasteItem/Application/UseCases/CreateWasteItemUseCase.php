<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemCategory;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemDescription;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemName;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemPoints;

class CreateWasteItemUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(CreateWasteItemDTOs $dto): WasteItem
    {
        $wasteItem = new WasteItem(
            new WasteItemId($dto->getId()),
            new WasteItemName($dto->getName()),
            new WasteItemDescription($dto->getDescription()),
            new WasteItemCategory($dto->getCategory()),
            new WasteItemPoints($dto->getPoints())
        );

        $this->repository->create($wasteItem);

        return $wasteItem;
    }
}
