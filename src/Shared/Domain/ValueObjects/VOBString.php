<?php

namespace Src\shared\Domain\ValueObjects;
use InvalidArgumentException;

abstract class VOBString{

    protected string $value;

    public function __construct(string $value){
        if (trim($value) === '') {
            throw new InvalidArgumentException('El texto no puede estar vacío.');
        }

        $this->value = trim($value);
    }

    public function value(): string { return $this->value; }

}