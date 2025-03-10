<?php

namespace App\Domain\Exceptions;

class WeakPasswordException extends \InvalidArgumentException
{
    // Se puede agregar más lógica si se requiere
    public function __construct(string $message = "La contraseña es débil", int $code = 400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
