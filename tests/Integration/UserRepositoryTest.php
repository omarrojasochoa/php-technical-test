<?php

use PHPUnit\Framework\TestCase;
use Orojaso\PhpTechnicalTest\Infrastructure\DoctrineUserRepository;
use Orojaso\PhpTechnicalTest\Domain\Entities\User;
use Orojaso\PhpTechnicalTest\Domain\Entities\UserId;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Password;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Name;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\UserAlreadyExistsException;

class UserRepositoryTest extends TestCase
{
    public function testSaveUser()
    {
        $mockRepository = $this->createMock(DoctrineUserRepository::class);
        
        $mockRepository->expects($this->once())
                       ->method('save')
                       ->with($this->isInstanceOf(User::class));

        $user = new User(
            new Name('John Doe'),
            new Email('john.doe@example.com'),
            new Password('Password123!'),
            new \DateTime()
        );

        $mockRepository->save($user);

        $this->assertTrue(true);
    }

    public function testFindUserById()
    {
        $mockRepository = $this->createMock(DoctrineUserRepository::class);

        $mockRepository->expects($this->once())
                       ->method('findById')
                       ->with($this->isInstanceOf(UserId::class))
                       ->willReturn(new User(
                           new Name('John Doe'),
                           new Email('john.doe@example.com'),
                           new Password('Password123!'),
                           new \DateTime()
                       ));

        $user = $mockRepository->findById(new UserId('123'));
        $this->assertInstanceOf(User::class, $user);
    }

    public function testDeleteUser()
    {
        // Crea mock en Doctrine
        $mockRepository = $this->createMock(DoctrineUserRepository::class);

        // delete()
        $mockRepository->expects($this->once())
                       ->method('delete')
                       ->with($this->isInstanceOf(UserId::class));

        // Llama metodo
        $mockRepository->delete(new UserId('123'));
        $this->assertTrue(true);
    }
}
