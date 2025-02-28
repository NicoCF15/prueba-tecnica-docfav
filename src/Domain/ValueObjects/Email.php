<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Exceptions\InvalidEmailException;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: "string")]
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("El correo es inválido");
        }
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

