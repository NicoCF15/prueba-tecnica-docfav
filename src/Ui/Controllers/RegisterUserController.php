<?php

namespace App\Ui\Controllers;

use App\Application\Dto\RegisterUserRequest;
use App\Application\Dto\UserResponseDto;
use App\Application\Service\RegisterUserUseCase;
use App\Domain\Events\Handler\UserRegisteredHandler;
use App\Infrastructure\Repository\DoctrineUserRepository;

use App\Domain\ValueObjects\Password;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Email;
use App\Application\Service\EmailService;
use App\Application\Service\UserRegistrationService;
use App\Domain\Events\User\UserRegisteredEvent;
use App\Infrastructure\Events\EventDispatcher;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;
    private EventDispatcher $eventDispatcher;

    public function __construct(RegisterUserUseCase $registerUserUseCase, EventDispatcher $eventDispatcher)
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function register()
    {
        // Verificar que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendErrorResponse("Invalid HTTP method", 405);
            return;
        }

        // Obtener los datos JSON del cuerpo de la solicitud
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        // Validar los campos necesarios
        if (!(isset($data['name']) && isset($data['email']) && isset($data['password']))) {
            $this->sendErrorResponse("Invalid body", 400);
            return;
        }

        // Crear Value Objects para el nombre, correo y contraseña
        try {
            $name = new Name($data['name']);
            $email = new Email($data['email']);
            $password = new Password($data['password']);
        } 
        catch (\InvalidArgumentException $e) {

            $this->sendErrorResponse($e->getMessage(), $e->getCode());
            return;
        }

        // Ejecutar el caso de uso
        try {
            $registerUserRequest = new RegisterUserRequest($name, $email, $password);

            $emailService = new EmailService();
            $eventHandler = new UserRegisteredHandler($emailService);
            $this->eventDispatcher->addListener(UserRegisteredEvent::class, [$eventHandler, 'handle']);

            $userResponseDTO = $this->registerUserUseCase->execute($registerUserRequest);

            $this->sendSuccessResponse($userResponseDTO);
        } catch (\Exception $e) {
            $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    private function sendErrorResponse(string $message, int $code){
        $userResponseDTO = new UserResponseDto(false, $message, $code);
        header('Content-Type: application/json', true, $code);
        echo json_encode($userResponseDTO->getDtoData());
    }

    private function sendSuccessResponse(UserResponseDto $userResponseDTO){
        header('Content-Type: application/json');
        echo json_encode($userResponseDTO->getDtoData());
    }

}

// Aquí la instancia del controlador con la inyección del caso de uso.
$entityManager = require '/var/www/html/src/config/bootstrap.php';
$userRepository = new DoctrineUserRepository($entityManager);
$eventDispatcher = new EventDispatcher();
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

$controller = new RegisterUserController($registerUserUseCase, $eventDispatcher);
$controller->register();


