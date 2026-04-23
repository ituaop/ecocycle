<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;

class GetWasteItemsByCategoryUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(string $category): array
    {
        return $this->repository->getByCategory($category);
    }
}
