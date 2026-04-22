<?php

namespace Src\Shared\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

 abstract class VOBUuid{

 protected string $value;

 public function __construct(?string $value=null){
    if($value == null){
            $this->value = Uuid::uuid4()->toString();
        }else{
            $this->ensureIsValidUuid($value);
            $this->value = $value;
 }
 }

 public function value(): string { return $this->value; }

    public function ensureISValidUuid(string $id)
    {
        if(!Uuid::isValid($id)){
            throw new InvalidArgumentException(
                sprintf('The value <%s> is not a valid UUID. Please try again.', static::class, $id));
        }
    }
}