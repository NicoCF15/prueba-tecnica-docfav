<?php
namespace App\Domain\Service;

use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Application\Dto\RegisterUserRequest;

class UserRegistrationDomainService{
    public function createRegisterUserRequest(string $name, string $email, string $password): RegisterUserRequest{

        $name = new Name($name);  
        $email = new Email($email); 
        $password = new Password($password);  
        return new RegisterUserRequest($name, $email, $password);

    }
}
