<?php

namespace Src\Recycling\WasteItem\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\WasteItem\Application\UseCases\GetAllWasteItemsUseCase;
use Src\Recycling\WasteItem\Domain\Entities\WasteItem;

class GetAllWasteItemsController extends Controller
{
    public function __construct(private GetAllWasteItemsUseCase $useCase) {}

    public function __invoke(): JsonResponse
    {
        try {
            $result = $this->useCase->execute();

            $data = array_map(fn(WasteItem $i) => [
                'id'          => $i->getIdValue(),
                'name'        => $i->getNameValue(),
                'description' => $i->getDescriptionValue(),
                'category'    => $i->getCategoryValue(),
                'points'      => $i->getPointsValue(),
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
