<?php

//namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
#[ORM\Entity]
#[ORM\Table(name: 'user')]
class User
{
     /** 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;


    #[ORM\Column(type: 'string')]
    private string $email;
        

    #[ORM\Column(type: 'string')]
    private string $password;
    
    /** @ORM\Column(type="string") */
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    /**
     * Constructor para inicializar el producto.
     *
     * @param string $name Nombre del producto.
     * @param float $price Precio del producto.
     * @param int $quantity Cantidad disponible del producto.
     */
    public function __construct(string $name, float $email, int $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function setUpdated(): void
    {
        // WILL be saved in the database
        $this->createdAt = new DateTime("now");
    }

    /**
     * Obtiene el nombre del producto.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Establece el nombre del producto.
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Obtiene el precio del producto.
     *
     * @return float
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Establece el precio del producto.
     *
     * @param float $price
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}

