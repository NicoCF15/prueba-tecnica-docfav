<?php
// tests/RegisterUserUseCaseTest.php

use App\Application\Dto\RegisterUserRequest;
use PHPUnit\Framework\TestCase;
use App\Application\Service\RegisterUserUseCase;
use App\Domain\Model\Entity\User;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Events\EventDispatcher;

class RegisterUserUseCaseTest extends TestCase
{
    
    public function testRegisterUser()
    {
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $userRepositoryMock->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $eventDispatcherMock = $this->createMock(EventDispatcher::class);

        //$userId = new UserId('123');
        $name = new Name('Mario');
        $email = new Email('test@example.com');
        $password = new Password('M1ContraseniaSegura#');

        $registerUserRequestMock = new RegisterUserRequest($name,$email,$password);
        
        $useCase = new RegisterUserUseCase($userRepositoryMock, $eventDispatcherMock);
        $result = $useCase->execute($registerUserRequestMock);
        
        $this->assertTrue($result);
        
    }
    
}
