<?php

namespace Src\Recycling\CollectionPoint\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\CollectionPoint\Application\UseCases\DeleteCollectionPointUseCase;

class DeleteCollectionPointController extends Controller
{
    public function __construct(private DeleteCollectionPointUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->useCase->execute($id);

            return response()->json([
                'status'  => 'deleted',
                'message' => 'Punto de recogida eliminado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
