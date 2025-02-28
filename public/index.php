<?php
use App\Ui\Controllers\RegisterUserController;
use App\Application\Service\RegisterUserUseCase;
use App\Infrastructure\Events\EventDispatcher;
use App\Infrastructure\Repository\DoctrineUserRepository;

// Aquí cargamos las dependencias o configuraciones necesarias
require_once realpath(__DIR__ . '/../vendor/autoload.php');
require_once __DIR__ . '/../Router/Router.php';

// Instanciamos el router
$router = new Router();

$router->post('/user', function() {
    $entityManager = require_once realpath(__DIR__ . '/../src/config/bootstrap.php');
    
    $userRepository = new DoctrineUserRepository($entityManager);
    $eventDispatcher = new EventDispatcher();
    $registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
    
    $controller = new RegisterUserController($registerUserUseCase, $eventDispatcher);
    $controller->register();
});

// El router se encarga de manejar la solicitud
$router->run();