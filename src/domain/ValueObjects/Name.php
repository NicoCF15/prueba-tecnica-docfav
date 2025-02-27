<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Name
{
    #[ORM\Column(type: "string")]
    private $name;

    public function __construct(string $name)
    {
        if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format");
        }
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

