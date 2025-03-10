<?php

namespace Orojaso\PhpTechnicalTest\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserUseCase;
use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserRequest;
use Orojaso\PhpTechnicalTest\Domain\Entities\UserRepositoryInterface;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Name;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Password;
use Orojaso\PhpTechnicalTest\Domain\Entities\User;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\UserAlreadyExistsException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\InvalidEmailException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\WeakPasswordException;
use Orojaso\PhpTechnicalTest\Infrastructure\EventDispatcher;
use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEventListener;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private $useCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcher::class);
        
        // Inicializar el caso de uso
        $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    
    }

    public function testRegisterUserSuccessfully()
    {
        $request = new RegisterUserRequest('Omar Rojas', 'omar.rojas@example.com', 'Password123!');

        $name = new Name('Omar Rojas');
        $password = new Password('Password123!');
        $email = new \Orojaso\PhpTechnicalTest\Domain\Entities\Email('omar.rojas@example.com'); 

        $this->userRepository->method('findByEmail')->willReturn(null); 

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(\Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEvent::class)); 

        $this->useCase->execute($request);

        $this->assertTrue(true);
    }

    public function testEmailAlreadyInUse()
    {
        $request = new RegisterUserRequest('Omar Rojas', 'omar.rojas@example.com', 'Password123!');
        $existingUser = $this->createMock(User::class);
        
        $this->userRepository->method('findByEmail')->willReturn($existingUser);  

        $this->expectException(UserAlreadyExistsException::class);

        $this->useCase->execute($request);
    }

    public function testInvalidEmailFormat()
    {
        $this->expectException(InvalidEmailException::class);

        $request = new RegisterUserRequest('Omar Rojas', 'invalid-email', 'Password123!');
        $this->useCase->execute($request);
    }

    public function testWeakPassword()
    {
        $this->expectException(WeakPasswordException::class);

        $request = new RegisterUserRequest('Omar Rojas', 'omar.rojas@example.com', 'weak');
        $this->useCase->execute($request);
    }
}
