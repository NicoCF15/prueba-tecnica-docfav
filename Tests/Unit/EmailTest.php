<?php
namespace Tests\Unit;

use App\Domain\Exceptions\InvalidEmailException;
use App\Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testEmailCreation(){
        $email = new Email('alma.marcela@gmail.com');

        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('alma.marcela@gmail.com', $email->getEmail());
    }

    public function testInvalidEmailWithoutUsername(){
        $this->expectException(InvalidEmailException::class);
        new Email('@gmail.com');
    }

    public function testInvalidEmailWithoutAtSimbol(){
        $this->expectException(InvalidEmailException::class);
        new Email('alma.marcelagmail.com');
    }

    public function testInvalidEmailWithoutDomainName(){
        $this->expectException(InvalidEmailException::class);
        new Email('alma.marcela@.com');
    }

    public function testInvalidEmailWithoutDot(){
        $this->expectException(InvalidEmailException::class);
        new Email('alma.marcela@gmailcom');
    }

    public function testInvalidEmailWithoutTopLevelDomain(){
        $this->expectException(InvalidEmailException::class);
        new Email('alma.marcela@gmail');
    }
}
