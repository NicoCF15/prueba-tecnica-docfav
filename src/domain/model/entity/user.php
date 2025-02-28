<?php

namespace App\Domain\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;

use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{

    #[ORM\Embedded(class: UserId::class)]
    private UserId $id;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Embedded(class: Email::class)]
    private Email $email;
        
    #[ORM\Embedded(class: Password::class)]
    private Password $password;
    
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function __construct(Name $name, Email $email, Password $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new DateTime("now");
    }

    public function setUpdated(): void
    {
        $this->createdAt = new DateTime("now");
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

}

