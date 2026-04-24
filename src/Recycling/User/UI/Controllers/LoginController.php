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
use Src\Recycling\User\Infraestructure\Models\UserModel;
use Src\Recycling\User\UI\Requests\LoginUserRequest;

/**
 * Controller de Login (Log In).
 *
 * GET  /login  → muestra la vista Login.tsx (Inertia)
 * POST /login  → procesa las credenciales y abre sesión
 */
class LoginController extends Controller
{
    public function __construct(private LoginUserUseCase $useCase) {}

    /**
     * Muestra la página de login.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => true,
            'status'           => session('status'),
        ]);
    }

    /**
     * Procesa el formulario de login.
     */
    public function store(LoginUserRequest $request): RedirectResponse
    {
        try {
            // 1. Construir DTO
            $dto = new LoginUserDTO(
                email:         $request->input('email'),
                plainPassword: $request->input('password'),
                remember:      (bool) $request->input('remember', false)
            );

            // 2. Ejecutar caso de uso — valida credenciales en el dominio
            $domainUser = $this->useCase->execute($dto);

            // 3. Autenticar con el modelo Eloquent Authenticatable
            //    El caso de uso ya verificó la contraseña, solo necesitamos el modelo
            $authModel = UserModel::find($domainUser->getIdValue());

            if (!$authModel) {
                throw new Exception('Las credenciales no son correctas.');
            }

            Auth::login($authModel, remember: $dto->getRemember());

            // 4. Regenerar sesión (seguridad: session fixation)
            $request->session()->regenerate();

            // 5. Redirigir al destino previsto o al dashboard
            return redirect()->intended(route('dashboard'));

        } catch (Exception $e) {
            // Mensaje genérico: no revelar si el email existe o no
            return back()->withErrors([
                'email' => $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function destroy(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
