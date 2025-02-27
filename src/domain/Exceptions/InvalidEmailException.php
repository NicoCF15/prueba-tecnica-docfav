<?php

namespace App\Domain\Exceptions;

class InvalidEmailException extends \InvalidArgumentException
{
    // Se puede agregar más lógica si se requiere
    public function __construct(string $message = "El formato del correo electrónico es inválido", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
