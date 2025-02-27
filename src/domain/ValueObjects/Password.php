<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Exceptions\WeakPasswordException;

#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: "string")]
    private $password;

    public function __construct(string $password)
    {
        // Expresión regular para validar la contraseña
        $pattern = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/';

        if (!preg_match($pattern, $password)) {
            throw new WeakPasswordException("Contraseña débil");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

