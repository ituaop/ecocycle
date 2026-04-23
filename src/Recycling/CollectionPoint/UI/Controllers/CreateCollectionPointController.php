<?php

namespace Src\Recycling\CollectionPoint\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\UseCases\CreateCollectionPointUseCase;

class CreateCollectionPointController extends Controller
{
    public function __construct(private CreateCollectionPointUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $dto = new CreateCollectionPointDTOs(
                $request->input('id'),
                $request->input('name'),
                $request->input('address'),
                (float) $request->input('latitude'),
                (float) $request->input('longitude'),
                $request->input('status', 'ACTIVE')
            );

            $cp = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Punto de recogida creado correctamente.',
                'data'    => ['id' => $cp->getIdValue()],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
