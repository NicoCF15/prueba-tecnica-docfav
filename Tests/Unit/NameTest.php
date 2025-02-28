<?php

use App\Domain\Exceptions\InvalidNameException;
use PHPUnit\Framework\TestCase;
use App\Domain\ValueObjects\Name;

class NameTest extends TestCase{

    public function testName(){
        $name = new Name('John Doe');
        $this->assertSame('John Doe', $name->getName());
    }

    public function testShortName(){
        //Dejo el largo del nombre en 2 por nombres como Xi
        $this->expectException(InvalidNameException::class);
        new Name('a');
    }

    public function testInvalidCharacters(){
        //Dejo el largo del nombre en 2 por nombres como Xi
        $this->expectException(InvalidNameException::class);
        new Name('Vegeta777');
    }

}
