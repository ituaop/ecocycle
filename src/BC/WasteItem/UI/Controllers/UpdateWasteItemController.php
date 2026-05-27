<?php

namespace Src\Recycling\WasteItem\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\UseCases\UpdateWasteItemUseCase;

class UpdateWasteItemController extends Controller
{
    public function __construct(private UpdateWasteItemUseCase $useCase) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new CreateWasteItemDTO(
                id:          $id,
                name:        $request->input('name'),
                description: $request->input('description'),
                category:    $request->input('category'),
                points:      (int) $request->input('points')
            );

            $item = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'WasteItem actualizado correctamente.',
                'data'    => [
                    'id'          => $item->getIdValue(),
                    'name'        => $item->getNameValue(),
                    'description' => $item->getDescriptionValue(),
                    'category'    => $item->getCategoryValue(),
                    'points'      => $item->getPointsValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
