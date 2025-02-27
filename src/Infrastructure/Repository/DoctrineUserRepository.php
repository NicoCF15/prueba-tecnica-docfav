<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Model\Entity\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepositoryInterface
{

    private EntityManagerInterface $entityManager;
    private ObjectRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    public function save(User $user): void{
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User{
        return $this->userRepository->find($id);
    }

    public function findByEmail(Email $email): ?User{
        $emailValue = $email->getEmail();
        return $this->userRepository->findOneBy(['email.email' => $emailValue]);   
    }

    public function delete(UserId $id): void{
        $this->entityManager->remove($id);
        $this->entityManager->flush();
    }

}

