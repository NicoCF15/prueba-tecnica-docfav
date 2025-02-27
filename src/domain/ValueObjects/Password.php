<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Exception\WeakPasswordException;

#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: "string")]
    private $password;

    public function __construct(string $password)
    {
        if (!filter_var($password, FILTER_VALIDATE_EMAIL)) {
            throw new WeakPasswordException("Contraseña débil");
        }
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

