<?php

namespace Orojaso\PhpTechnicalTest\Infrastructure;

use Orojaso\PhpTechnicalTest\Domain\Entities\User;
use Orojaso\PhpTechnicalTest\Domain\Entities\UserId;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\Entities\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->getId());
    }

    public function delete(UserId $id): void
    {
        $user = $this->entityManager->find(User::class, $id->getId());
        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $email->getEmail()]); 
    }
}
