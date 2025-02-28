<?php
// tests/UserTest.php

use PHPUnit\Framework\TestCase;
use App\Domain\Model\Entity\User;
use App\Domain\ValueObjects\UserId;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Name;
use App\Domain\ValueObjects\Password;

class UserTest extends TestCase
{
    public function testUserEntity()
    {
        
        //$userId = new UserId();
        $email = new Email('test@example.com');
        $name = new Name('Juana');
        $password = new Password('M1C0ntraseniaS3cr3ta1#');
        
        $user = new User($name, $email, $password);

        //$this->assertSame(1, $user->getId()->getId());
        $this->assertSame('test@example.com', $user->getEmail()->getEmail());
        $this->assertSame('Juana', $user->getName()->getName());
        $this->assertTrue(password_verify('M1C0ntraseniaS3cr3ta1#', $user->getPassword()->getPassword()));
        
    }
}
