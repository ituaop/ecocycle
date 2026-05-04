<?php

namespace Src\Recycling\RecycleAction\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\RecycleAction\Application\UseCases\ReadRecycleActionUseCase;

class ReadRecycleActionController extends Controller
{
    public function __construct(private ReadRecycleActionUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $action = $this->useCase->execute($id);

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'                  => $action->getIdValue(),
                    'user_id'             => $action->getUserIdValue(),
                    'waste_item_id'       => $action->getWasteItemIdValue(),
                    'collection_point_id' => $action->getCollectionPointIdValue(),
                    'quantity'            => $action->getQuantityValue(),
                    'date'                => $action->getDateValue(),
                    'points_earned'       => $action->getPointsEarnedValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
