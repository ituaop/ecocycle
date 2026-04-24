<?php

namespace Src\Recycling\User\UI\Requests;

use Illuminate\Foundation\Http\FormRequest;


class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !auth()->check();
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Introduce un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }
}
