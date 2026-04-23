<?php

namespace Src\Recycling\User\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\User\Application\UseCases\ReadUserUseCase;

class ReadUserController extends Controller
{
    public function __construct(private ReadUserUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $user = $this->useCase->execute($id);

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'           => $user->getIdValue(),
                    'username'     => $user->getUsernameValue(),
                    'email'        => $user->getEmailValue(),
                    'level'        => $user->getLevelValue(),
                    'total_points' => $user->getTotalPointsValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
