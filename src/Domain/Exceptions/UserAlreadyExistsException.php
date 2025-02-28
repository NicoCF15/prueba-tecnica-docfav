<?php

namespace App\Domain\Exceptions;

class UserAlreadyExistsException extends \InvalidArgumentException
{
    // Se puede agregar más lógica si se requiere
    public function __construct(string $message = "El usuario ya existe en la base de datos", int $code = 400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
