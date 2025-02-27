<?php

namespace App\Domain\Exception;

class UserAlreadyExistsException extends \InvalidArgumentException
{
    // Se puede agregar más lógica si se requiere
    public function __construct(string $message = "El usuario ya existge en la base de datos", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
