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
                $request->input('id'),
                $request->input('username'),
                $request->input('email'),
                $request->input('password'),
                $request->input('level', 'BEGINNER'),
                (int) $request->input('total_points', 0)
            );

            $user = $this->useCase->execute($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Usuario creado correctamente.',
                'data'    => ['id' => $user->getIdValue()],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
