<?php
namespace App\Infrastructure\Service;

use App\Domain\Events\User\UserRegisteredEvent;
use App\Domain\Events\Handler\UserRegisteredHandler;
use App\Infrastructure\Events\EventDispatcher;
use App\Application\Service\EmailService;

class EventHandlerInitializationService
{
    private EventDispatcher $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function initializeEventHandlers(): void
    {
        // Instancia el EmailService
        $emailService = new EmailService();

        // Crea el Event Handler con el EmailService
        $userRegisteredHandler = new UserRegisteredHandler($emailService);

        // Registra el listener en el EventDispatcher
        $this->eventDispatcher->addListener(UserRegisteredEvent::class, [$userRegisteredHandler, 'handle']);
    }
}
