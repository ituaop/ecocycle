<?php

namespace Src\Recycling\User\UI\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Solo usuarios no autenticados pueden registrarse
        return !auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'min:2', 'max:100'],
            'email'                 => ['required', 'email', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'max:128'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                  => 'El nombre es obligatorio.',
            'name.min'                       => 'El nombre debe tener al menos 2 caracteres.',
            'email.required'                 => 'El correo electrónico es obligatorio.',
            'email.email'                    => 'Introduce un correo electrónico válido.',
            'password.required'              => 'La contraseña es obligatoria.',
            'password.min'                   => 'La contraseña debe tener al menos 8 caracteres.',
            'password_confirmation.required' => 'Debes confirmar la contraseña.',
            'password_confirmation.same'     => 'Las contraseñas no coinciden.',
        ];
    }
}
