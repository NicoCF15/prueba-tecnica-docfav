<?php

namespace App\Application\Controller;

use App\Application\Dto\RegisterUserRequest;
use App\Application\Dto\UserResponseDto;
use App\Application\Service\RegisterUserUseCase;

use App\Infrastructure\Repository\DoctrineUserRepository;

use App\Domain\ValueObjects\Password;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Email;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register()
    {
        // Verificar que la solicitud sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $userResponseDTO = new UserResponseDto(
                false, 
                "Invalid HTTP method", 
                405
            );

            header('Content-Type: application/json');
            echo json_encode($userResponseDTO->getDtoData());
            return;
        }

        // Obtener los datos JSON del cuerpo de la solicitud
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        // Validar los campos necesarios
        if (!(isset($data['name']) && isset($data['email']) && isset($data['password']))) {
            $userResponseDTO = new UserResponseDto(
                false, 
                "Invalid body", 
                400
            );

            header('Content-Type: application/json');
            echo json_encode($userResponseDTO->getDtoData());
            return;
        }

        // Crear Value Objects para el nombre, correo y contraseña
        try {
            $name = new Name($data['name']);
            $email = new Email($data['email']);
            $password = new Password($data['password']);
        } 
        catch (\InvalidArgumentException $e) {

            http_response_code($e->getCode());

            $userResponseDTO = new UserResponseDto(
                false, 
                $e->getMessage(), 
                $e->getCode()
            );

            header('Content-Type: application/json');
            echo json_encode($userResponseDTO->getDtoData());
            return;
        }

        // Ejecutar el caso de uso
        try {
            $registerUserRequest = new RegisterUserRequest($name, $email, $password);
            $userResponseDTO = $this->registerUserUseCase->execute($registerUserRequest);

            // Preparar la respuesta JSON
            $response = [
                ...$userResponseDTO->getDtoData()
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Aquí la instancia del controlador con la inyección del caso de uso.
$entityManager = require '/var/www/html/src/config/bootstrap.php';
$userRepository = new DoctrineUserRepository($entityManager);
$registerUserUseCase = new RegisterUserUseCase($userRepository);

$controller = new RegisterUserController($registerUserUseCase);
$controller->register();


