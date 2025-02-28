<?php
// tests/Domain/ValueObjects/PasswordTest.php
namespace Tests\Unit;

use App\Domain\ValueObjects\Password;
use App\Domain\Exceptions\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase{

    public function testPasswordCreation(){
        $password = new Password('M1C0ntr4s3n14S3gur4#');
        $this->assertInstanceOf(Password::class, $password);
        $this->assertTrue(password_verify('M1C0ntr4s3n14S3gur4#',$password->getPassword()));
    }

    public function testShortPassword(){
        $this->expectException(WeakPasswordException::class);
        new Password('M1c0nt#');
    }

    public function testPasswordWithoutSpecialCharacter(){
        $this->expectException(WeakPasswordException::class);
        new Password('M1c0nTr4s3n14S3gur4');
    }

    public function testPasswordWithoutNumber(){
        $this->expectException(WeakPasswordException::class);
        new Password('MiContraseniaS?egura#');
    }

    public function testPasswordWithoutUpperCase(){
        $this->expectException(WeakPasswordException::class);
        new Password('m1c0ntr4senias3gur4#');
    }
}
