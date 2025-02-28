<?php

namespace App\Application\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;

/**
* Data transfer object to create a user
*
* The DTO recibe post data of name, email and password when a create user request is called.
* @package App\Application\Dto
*/
class RegisterUserRequest
{
    private Name $name;
    private Email $email;
    private Password $password;

    public function __construct(Name $name, Email $email, Password $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
    * Getter of name property of DTO
    *
    * @return Name
    */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
    * Getter of email property of DTO
    *
    * @return Email
    */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
    * Getter of password property of DTO
    *
    * @return Password
    */
    public function getPassword(): Password
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return "UserDTO{name={$this->name}, email={$this->email}}";
    }

}

