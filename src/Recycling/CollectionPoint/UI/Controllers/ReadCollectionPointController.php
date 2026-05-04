<?php

namespace Src\Recycling\CollectionPoint\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\CollectionPoint\Application\UseCases\ReadCollectionPointUseCase;

class ReadCollectionPointController extends Controller
{
    public function __construct(private ReadCollectionPointUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $cp = $this->useCase->execute($id);

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'        => $cp->getIdValue(),
                    'name'      => $cp->getNameValue(),
                    'address'   => $cp->getAddressValue(),
                    'latitude'  => $cp->getLatitudeValue(),
                    'longitude' => $cp->getLongitudeValue(),
                    'status'    => $cp->getStatusValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
