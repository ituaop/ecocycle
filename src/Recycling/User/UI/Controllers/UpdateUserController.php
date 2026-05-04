<?php

namespace Src\Recycling\User\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\UseCases\UpdateUserUseCase;

class UpdateUserController extends Controller
{
    public function __construct(private UpdateUserUseCase $useCase) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new CreateUserDTO(
                id:          $id,
                name:        $request->input('name'),
                username:    $request->input('username'),
                email:       $request->input('email'),
                level:       $request->input('level'),
                totalPoints: (int) $request->input('total_points', 0)
            );

            $user = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Usuario actualizado correctamente.',
                'data'    => [
                    'id'           => $user->getIdValue(),
                    'name'         => $user->getNameValue(),
                    'username'     => $user->getUsernameValue(),
                    'email'        => $user->getEmailValue(),
                    'level'        => $user->getLevelValue(),
                    'total_points' => $user->getTotalPointsValue(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
