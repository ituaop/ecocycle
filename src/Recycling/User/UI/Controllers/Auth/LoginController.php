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
            $dto = new LoginUserDTO(
                email:         $request->input('email'),
                plainPassword: $request->input('password'),
                remember:      (bool) $request->input('remember', false)
            );

            // El UseCase valida las credenciales en el dominio
            $domainUser = $this->useCase->execute($dto);

            // Autenticar con el modelo Eloquent
            $authModel = UserAuthModel::find($domainUser->getIdValue());

            if (!$authModel) {
                throw new Exception('Las credenciales no son correctas.');
            }

            Auth::login($authModel, remember: $dto->getRemember());
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));

        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput($request->except('password'));
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
