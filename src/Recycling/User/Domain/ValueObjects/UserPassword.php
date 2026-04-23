<?php

namespace Src\Recycling\User\Domain\ValueObjects;

use InvalidArgumentException;
use Src\shared\Domain\ValueObjects\VOBString;

class UserPassword extends VOBString{
    private string $value;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->value = $password;
    }

    private function validate(string $password): void
    {
        // Regla de negocio: mínimo 8 caracteres
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("La contraseña debe tener al menos 8 caracteres.");
        }
        
       
    }

    public function value(): string
    {
        return $this->value;
    }

    // Método para comparar (útil en el login)
    public function equals(UserPassword $other): bool
    {
        return $this->value === $other->value();
    }
}
