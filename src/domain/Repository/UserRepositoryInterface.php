<?php

namespace App\Domain\Repository;

use App\Domain\Model\Entity\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function delete(UserId $id): void;

}

