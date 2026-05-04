<?php

namespace Src\Recycling\WasteItem\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\WasteItem\Application\UseCases\ReadWasteItemUseCase;

class ReadWasteItemController extends Controller
{
    public function __construct(private ReadWasteItemUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $item = $this->useCase->execute($id);

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'          => $item->getIdValue(),
                    'name'        => $item->getNameValue(),
                    'description' => $item->getDescriptionValue(),
                    'category'    => $item->getCategoryValue(),
                    'points'      => $item->getPointsValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
