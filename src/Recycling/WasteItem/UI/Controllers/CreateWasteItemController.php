<?php

namespace Src\Recycling\WasteItem\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\UseCases\CreateWasteItemUseCase;

class CreateWasteItemController extends Controller
{
    public function __construct(private CreateWasteItemUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $dto = new CreateWasteItemDTO(
                id:          $request->input('id'),
                name:        $request->input('name'),
                description: $request->input('description'),
                category:    $request->input('category'),
                points:      (int) $request->input('points', 0)
            );

            $item = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'WasteItem creado correctamente.',
                'data'    => ['id' => $item->getIdValue()],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
