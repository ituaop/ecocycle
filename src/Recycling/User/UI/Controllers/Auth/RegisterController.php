<?php

namespace Src\Recycling\User\UI\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\User\Application\DTOs\RegisterUserDTO;
use Src\Recycling\User\Application\UseCases\RegisterUserUseCase;
use Src\Recycling\User\Infraestructure\Models\UserAuthModel;
use Src\Recycling\User\Infraestructure\Models\UserModel;
use Src\Recycling\User\UI\Requests\RegisterUserRequest;

/**
 * Controller de Registro (Create Account).
 *
 * GET  /register  → muestra la vista Register.tsx (Inertia)
 * POST /register  → procesa el formulario, crea el usuario y hace login automático
 */
class RegisterController extends Controller
{
    public function __construct(private RegisterUserUseCase $useCase) {}

    /**
     * Muestra la página de registro.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Procesa el formulario de registro.
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        try {
            // 1. Construir DTO con los datos validados del request
            $dto = new RegisterUserDTO(
                name:                 $request->input('name'),
                email:                $request->input('email'),
                plainPassword:        $request->input('password'),
                passwordConfirmation: $request->input('password_confirmation')
            );

            // 2. Ejecutar el caso de uso → crea y persiste el usuario
            $user = $this->useCase->execute($dto);

            // 3. Hacer login automático tras el registro
            //    Laravel necesita un modelo Authenticatable, no nuestra entidad de dominio.
            //    Buscamos el modelo recién creado y lo autenticamos.
            $authModel = UserModel::find($user->getIdValue());

            Auth::login($authModel, remember: false);

            // 4. Regenerar sesión para prevenir session fixation
            $request->session()->regenerate();

            // 5. Redirigir al dashboard
            return redirect()->intended(route('dashboard'));

        } catch (Exception $e) {
            // Devolver el error al formulario Inertia
            return back()->withErrors([
                'email' => $e->getMessage(),
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
