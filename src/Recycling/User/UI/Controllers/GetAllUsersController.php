<?php

namespace Src\Recycling\User\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\User\Application\UseCases\GetAllUsersUseCase;
use Src\Recycling\User\Domain\Entities\User;

class GetAllUsersController extends Controller
{
    public function __construct(private GetAllUsersUseCase $useCase) {}

    public function __invoke(): JsonResponse
    {
        try {
            $result = $this->useCase->execute();

            $data = array_map(fn(User $u) => [
                'id'           => $u->getIdValue(),
                'username'     => $u->getUsernameValue(),
                'email'        => $u->getEmailValue(),
                'level'        => $u->getLevelValue(),
                'total_points' => $u->getTotalPointsValue(),
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
