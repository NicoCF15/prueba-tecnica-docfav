<?php

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class UserId
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null; // El tipo de dato debe ser integer, ya que es generado automáticamente

    public function __construct(?int $id = null)
    {
        // in case we need to manually set the id, this is needed.
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function getId(): int | null
    {
        return $this->id;
    }
}

