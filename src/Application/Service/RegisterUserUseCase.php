<?php

namespace App\Application\Service;

use App\Application\Dto\RegisterUserRequest;
use App\Infrastructure\Repository\DoctrineUserRepository;
use App\Domain\Model\Entity\User;
use App\Application\DTO\UserResponseDto;
use App\Domain\Events\User\UserRegisteredEvent;
use App\Domain\Exceptions\UserAlreadyExistsException;
use App\Domain\ValueObjects\Email;

use App\Infrastructure\Events\EventDispatcher;

class RegisterUserUseCase
{
    private DoctrineUserRepository $userRepository;
    private EventDispatcher $eventDispatcher;

    public function __construct(DoctrineUserRepository $userRepository, EventDispatcher $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $registerUserRequest): UserResponseDTO
    {
        // Crear el nuevo usuario
        
        $name = $registerUserRequest->getName();
        $email = $registerUserRequest->getEmail();
        $password = $registerUserRequest->getPassword();
        
        // Validar si el email ya está en uso
        if ($this->isEmailUsed($email)) {
            throw new UserAlreadyExistsException("El usuario ya está en uso");
        }

        $user = new User($name, $email, $password);
        
        // Guardar el usuario en la base de datos
        $this->userRepository->save($user);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($name->getName(),$email->getEmail()));
        
        // Retornar el DTO con la información del usuario recién creado
        return new UserResponseDto(
            true, 
            "Usuario creado con éxito", 
            200
        );
        //return new UserResponseDTO(1, "hola", "hola", "hola");
    }

    public function isEmailUsed(Email $email): bool{
        $existingUser = $this->userRepository->findByEmail($email);
        return $existingUser !== null;
    }

}

