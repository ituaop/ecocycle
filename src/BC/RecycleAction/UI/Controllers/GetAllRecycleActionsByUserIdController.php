<?php

namespace Src\Recycling\RecycleAction\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\RecycleAction\Application\UseCases\GetAllRecycleActionsByUserIdUseCase;
use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;

class GetAllRecycleActionsByUserIdController extends Controller
{
    public function __construct(private GetAllRecycleActionsByUserIdUseCase $useCase) {}

    public function __invoke(string $userId): JsonResponse
    {
        try {
            $result = $this->useCase->execute($userId);

            $data = array_map(fn(RecycleAction $a) => [
                'id'                  => $a->getIdValue(),
                'user_id'             => $a->getUserIdValue(),
                'waste_item_id'       => $a->getWasteItemIdValue(),
                'collection_point_id' => $a->getCollectionPointIdValue(),
                'quantity'            => $a->getQuantityValue(),
                'date'                => $a->getDateValue(),
                'points_earned'       => $a->getPointsEarnedValue(),
            ], $result['items']);

            return response()->json([
                'data'       => $data,
                'pagination' => $result['pagination'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
