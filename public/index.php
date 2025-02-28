<?php

/**
* This file is an entrypoint to execute the project.
*/
use App\Infrastructure\Service\EventHandlerInitializationService;
use App\Ui\Controllers\RegisterUserController;
use App\Application\Service\RegisterUserUseCase;
use App\Infrastructure\Events\EventDispatcher;
use App\Infrastructure\Repository\DoctrineUserRepository;

require_once realpath(__DIR__ . '/../vendor/autoload.php');
require_once __DIR__ . '/../Router/Router.php';

$router = new Router();

$router->post('/user', function() {
    $entityManager = require_once realpath(__DIR__ . '/../src/config/bootstrap.php');
    
    $userRepository = new DoctrineUserRepository($entityManager);
    $eventDispatcher = new EventDispatcher();
    $eventInitializationService = new EventHandlerInitializationService($eventDispatcher);

    $eventInitializationService->initializeEventHandlers();

    $registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
    
    $controller = new RegisterUserController($registerUserUseCase);
    $controller->register();
});

$router->run();
