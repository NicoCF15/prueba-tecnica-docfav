<?php

// src/Service/UserRegistrationService.php
namespace App\Application\Service;

use App\Domain\Events\User\UserRegisteredEvent;
use App\Domain\Events\Handler\UserRegisteredHandler;

class UserRegistrationService
{
    private UserRegisteredHandler $eventHandler;

    public function __construct(UserRegisteredHandler $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    public function registerUser(string $email, string $name): void
    {
        // Aquí realizaríamos la lógica para registrar al usuario (guardarlo en la base de datos, etc.)

        // Después de registrar al usuario, disparamos el evento
        $event = new UserRegisteredEvent($email, $name);
        $this->eventHandler->handle($event);
    }
}
