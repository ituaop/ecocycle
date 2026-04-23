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
            $dto = new CreateRecycleActionDTOs(
                $request->input('id'),
                $request->input('user_id'),
                $request->input('waste_item_id'),
                $request->input('collection_point_id'),
                (int) $request->input('quantity'),
                $request->input('date', now()->format('Y-m-d')),
                (int) $request->input('points_earned', 0)
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
