<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Exceptions\InvalidNameException;

#[ORM\Embeddable]
class Name
{
    #[ORM\Column(type: "string")]
    private $name;

    public function __construct(string $name)
    {
        if (!preg_match( "/^[a-zA-Z]{2,}$/",$name)) {
            throw new InvalidNameException("El nombre es inválido");
        }
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

