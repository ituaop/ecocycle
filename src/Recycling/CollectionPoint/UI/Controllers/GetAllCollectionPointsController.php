<?php

namespace Src\Recycling\CollectionPoint\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\CollectionPoint\Application\UseCases\GetAllCollectionPointsUseCase;
use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;

class GetAllCollectionPointsController extends Controller
{
    public function __construct(private GetAllCollectionPointsUseCase $useCase) {}

    public function __invoke(): JsonResponse
    {
        try {
            $result = $this->useCase->execute();

            $data = array_map(fn(CollectionPoint $cp) => [
                'id'        => $cp->getIdValue(),
                'name'      => $cp->getNameValue(),
                'address'   => $cp->getAddressValue(),
                'latitude'  => $cp->getLatitudeValue(),
                'longitude' => $cp->getLongitudeValue(),
                'status'    => $cp->getStatusValue(),
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
