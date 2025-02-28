<?php

namespace App\Ui\Controllers;

use App\Application\Dto\UserResponseDto;
use App\Application\Service\RegisterUserUseCase;

use App\Domain\Service\UserRegistrationDomainService;


class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;
    private UserRegistrationDomainService $userRegistrationDomainService;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->userRegistrationDomainService = new UserRegistrationDomainService();
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

        // Ejecutar el caso de uso
        try {
            $registerUserRequest = $this->userRegistrationDomainService->createRegisterUserRequest($data['name'],$data['email'],$data['password']);

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