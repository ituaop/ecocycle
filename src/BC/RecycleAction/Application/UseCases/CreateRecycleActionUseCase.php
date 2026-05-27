<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Illuminate\Support\Str;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionCollectionPointId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionDate;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionPointsEarned;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionQuantity;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionUserId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionWasteItemId;

class CreateRecycleActionUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(CreateRecycleActionDTO $dto): RecycleAction
    {
        $action = new RecycleAction(
            new RecycleActionId($dto->getId() ?? Str::uuid()->toString()),
            new RecycleActionUserId($dto->getUserId()),
            new RecycleActionWasteItemId($dto->getWasteItemId()),
            new RecycleActionCollectionPointId($dto->getCollectionPointId()),
            new RecycleActionQuantity($dto->getQuantity()),
            new RecycleActionDate($dto->getDate()),
            new RecycleActionPointsEarned($dto->getPointsEarned())
        );

        $this->repository->create($action);

        return $action;
    }
}
