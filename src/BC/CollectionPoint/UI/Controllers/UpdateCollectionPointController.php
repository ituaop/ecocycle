<?php

namespace Src\Recycling\CollectionPoint\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\UseCases\UpdateCollectionPointUseCase;

class UpdateCollectionPointController extends Controller
{
    public function __construct(private UpdateCollectionPointUseCase $useCase) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new CreateCollectionPointDTO(
                id:                 $id,
                name:               $request->input('name'),
                address:            $request->input('address'),
                latitude:           (float) $request->input('latitude'),
                longitude:          (float) $request->input('longitude'),
                status:             $request->input('status'),
                schedule:           $request->input('schedule'),
                acceptedCategories: $request->input('accepted_categories', [])
            );

            $cp = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Punto de recogida actualizado correctamente.',
                'data'    => [
                    'id'        => $cp->getIdValue(),
                    'name'      => $cp->getNameValue(),
                    'address'   => $cp->getAddressValue(),
                    'latitude'  => $cp->getLatitudeValue(),
                    'longitude' => $cp->getLongitudeValue(),
                    'status'    => $cp->getStatusValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
