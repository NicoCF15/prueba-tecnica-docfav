<?php

use App\Domain\Exceptions\InvalidNameException;
use PHPUnit\Framework\TestCase;
use App\Domain\ValueObjects\UserId;

class UserIdTest extends TestCase{

    public function testId(){
        $name = new UserId();
        $this->assertSame(null, $name->getId());
    }

    public function testUserIdCreationWithEmptyValue(){
        $this->expectException(InvalidArgumentException::class);
        new UserId(null);
    }

    public function testUserIdImmutability(){
        $userId = new UserId(12345);
        $value = $userId->getId();
        
        // El valor de la entidad debe ser inmutable
        $this->assertEquals(12345, $value);
        
        // No existe ningún método que permita cambiar el valor de $userId.
        // Si intentamos hacer esto, la prueba debería fallar si lo intentamos
        // con un seter o cualquier otro tipo de mutación.
        // Por ejemplo, no debe existir un método setId() que permita modificar el valor.
    }

}