<?php

namespace Src\Recycling\User\UI\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\User\Application\DTOs\LoginUserDTO;
use Src\Recycling\User\Application\UseCases\LoginUserUseCase;
use Src\Recycling\User\Infraestructure\Models\UserAuthModel;
use Src\Recycling\User\UI\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function __construct(private LoginUserUseCase $useCase) {}

    /** GET /login */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => true,
            'status'           => session('status'),
        ]);
    }

    /** POST /login */
    public function store(LoginUserRequest $request): RedirectResponse
    {
        try {
            // 1. Validar credenciales en el dominio DDD
            $dto = new LoginUserDTO(
                email:         $request->input('email'),
                plainPassword: $request->input('password'),
                remember:      (bool) $request->input('remember', false)
            );

            $domainUser = $this->useCase->execute($dto);

            // 2. Recuperar el modelo Authenticatable por ID
            //    (el domainUser ya verificó las credenciales, solo buscamos el modelo)
            $authModel = UserAuthModel::find($domainUser->getIdValue());

            if (!$authModel) {
                throw new Exception('Las credenciales no son correctas.');
            }

            // 3. Iniciar sesión con el modelo Authenticatable
            Auth::login($authModel, $dto->getRemember());

            // 4. Regenerar sesión (previene session fixation)
            $request->session()->regenerate();

            // 5. Redirigir al dashboard
            return redirect()->intended(route('dashboard'));

        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput($request->only('email'));
        }
    }

    /** POST /logout */
    public function destroy(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
} 
