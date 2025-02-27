<?php

namespace App\Domain\Exceptions;

class InvalidNameException extends \InvalidArgumentException
{
    // Se puede agregar más lógica si se requiere
    public function __construct(string $message = "El nombre es invalido", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
