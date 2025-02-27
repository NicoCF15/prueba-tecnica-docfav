<?php

namespace App\Application\Service;

use App\Application\Dto\RegisterUserRequest;
use App\Infrastructure\Repository\DoctrineUserRepository;
use App\Domain\Model\Entity\User;
use App\Application\DTO\UserResponseDto;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;

class RegisterUserUseCase
{
    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserRequest $registerUserRequest): UserResponseDTO
    {
        // Crear el nuevo usuario
        
        $name = $registerUserRequest->getName();
        $email = $registerUserRequest->getEmail();
        $password = $registerUserRequest->getPassword();
        
        $user = new User($name, $email, $password);
        
        // Guardar el usuario en la base de datos
        $this->userRepository->save($user);
        
        // Retornar el DTO con la información del usuario recién creado
        return new UserResponseDto(
            true, 
            "Usuario creado con éxito", 
            200
        );
        //return new UserResponseDTO(1, "hola", "hola", "hola");
    }
}

