<?php

namespace Src\Recycling\RecycleAction\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\UseCases\CreateRecycleActionUseCase;

class CreateRecycleActionController extends Controller
{
    public function __construct(private CreateRecycleActionUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $dto = new CreateRecycleActionDTO(
                id:                $request->input('id'),
                userId:            $request->input('user_id'),
                wasteItemId:       $request->input('waste_item_id'),
                collectionPointId: $request->input('collection_point_id'),
                quantity:          (int) $request->input('quantity'),
                date:              $request->input('date', now()->format('Y-m-d')),
                pointsEarned:      (int) $request->input('points_earned', 0)
            );

            $action = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'RecycleAction registrada correctamente.',
                'data'    => [
                    'id'            => $action->getIdValue(),
                    'points_earned' => $action->getPointsEarnedValue(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
