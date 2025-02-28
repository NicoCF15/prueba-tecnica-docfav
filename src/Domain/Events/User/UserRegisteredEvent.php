<?php

namespace App\Domain\Events\User;

class UserRegisteredEvent
{
    private string $userEmail;
    private string $userName;

    public function __construct(string $userEmail, string $userName)
    {
        $this->userEmail = $userEmail;
        $this->userName = $userName;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
}
