<?php

namespace App\Application\Dto;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;

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

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return "UserDTO{name={$this->name}, email={$this->email}}";
    }

}

