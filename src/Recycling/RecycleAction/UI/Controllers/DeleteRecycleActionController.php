<?php

namespace Src\Recycling\RecycleAction\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\RecycleAction\Application\UseCases\DeleteRecycleActionUseCase;

class DeleteRecycleActionController extends Controller
{
    public function __construct(private DeleteRecycleActionUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->useCase->execute($id);

            return response()->json([
                'status'  => 'deleted',
                'message' => 'RecycleAction eliminada correctamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
