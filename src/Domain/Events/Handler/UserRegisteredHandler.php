<?php

namespace App\Domain\Events\Handler;

use App\Domain\Events\User\UserRegisteredEvent;
use App\Application\Service\EmailService;

class UserRegisteredHandler
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function handle(UserRegisteredEvent $event): void
    {
        // Aquí enviaríamos el correo de bienvenida
        $this->emailService->sendWelcomeEmail($event->getUserEmail(), $event->getUserName());
    }
}
