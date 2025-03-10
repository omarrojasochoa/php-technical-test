<?php

namespace Orojaso\PhpTechnicalTest\Domain\UseCases;

use Orojaso\PhpTechnicalTest\Domain\Entities\UserRepositoryInterface;
use Orojaso\PhpTechnicalTest\Domain\Entities\User;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Password;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Name;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\UserAlreadyExistsException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\InvalidEmailException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\WeakPasswordException;
use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEvent;
use Orojaso\PhpTechnicalTest\Infrastructure\EventDispatcher;

class RegisterUserUseCase
{
    private $userRepository;
    private $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): void
    {   
        $email = $request->getEmail();
    
        var_dump("Email to validate: " . $email);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidEmailException('Invalid email format');
        }


        $existingUser = $this->userRepository->findByEmail(new Email($request->getEmail()));
        if ($existingUser !== null) {
            throw new UserAlreadyExistsException('Email already in use');
        }

        $name = new Name($request->getName());  
        $email = new Email($request->getEmail());  
        $password = new Password($request->getPassword());  
        $createdAt = new \DateTime(); 

        $user = new User($name, $email, $password, $createdAt);
        $this->userRepository->save($user);

        // Disparar el evento de dominio
        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);
    }
}
