<?php

namespace Src\Recycling\User\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\UseCases\CreateUserUseCase;

class CreateUserController extends Controller
{
    public function __construct(private CreateUserUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $dto = new CreateUserDTO(
                id:          $request->input('id'),
                name:        $request->input('name'),
                username:    $request->input('username'),
                email:       $request->input('email'),
                level:       $request->input('level', 'BEGINNER'),
                totalPoints: (int) $request->input('total_points', 0)
            );

            $user = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Usuario creado correctamente.',
                'data'    => [
                    'id'       => $user->getIdValue(),
                    'name'     => $user->getNameValue(),
                    'username' => $user->getUsernameValue(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
