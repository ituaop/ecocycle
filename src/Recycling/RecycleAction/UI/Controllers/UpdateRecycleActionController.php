<?php

namespace Src\Recycling\RecycleAction\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\UseCases\UpdateRecycleActionUseCase;

class UpdateRecycleActionController extends Controller
{
    public function __construct(private UpdateRecycleActionUseCase $useCase) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new CreateRecycleActionDTO(
                id:                $id,
                userId:            $request->input('user_id'),
                wasteItemId:       $request->input('waste_item_id'),
                collectionPointId: $request->input('collection_point_id'),
                quantity:          (int) $request->input('quantity'),
                date:              $request->input('date'),
                pointsEarned:      (int) $request->input('points_earned')
            );

            $action = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'RecycleAction actualizada correctamente.',
                'data'    => [
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
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
