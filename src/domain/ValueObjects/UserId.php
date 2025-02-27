<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UserId
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}

