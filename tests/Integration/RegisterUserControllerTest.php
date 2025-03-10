<?php

namespace Orojaso\PhpTechnicalTest\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Orojaso\PhpTechnicalTest\Infrastructure\Controller\RegisterUserController;
use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserUseCase;
use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserRequest;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Name;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Password;
use Orojaso\PhpTechnicalTest\Domain\Entities\User;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\UserAlreadyExistsException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\InvalidEmailException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\WeakPasswordException;
use Orojaso\PhpTechnicalTest\Infrastructure\EventDispatcher;
use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEventListener;


class RegisterUserControllerTest extends TestCase
{
    public function testRegisterUserSuccessfully()
    {
      $useCase = $this->createMock(RegisterUserUseCase::class);

      $useCase->expects($this->once())
          ->method('execute')
          ->with($this->isInstanceOf(RegisterUserRequest::class));  // Asegura que se pase un DTO

      $controller = new RegisterUserController($useCase);

      $requestData = [
          'name' => 'Omar Rojas',
          'email' => 'omar.rojas@example.com',
          'password' => 'Password123!'
      ];

      $response = $controller->register($requestData);

      $this->assertStringContainsString('User registered successfully', $response);
    }

    public function testInvalidEmailFormat()
    {
      $requestData = [
          'name' => 'Omar Rojas',
          'email' => 'invalid-email', //email
          'password' => 'Password123!'
      ];

      // ejecutar la acción
      $useCaseMock = $this->createMock(RegisterUserUseCase::class);
      $useCaseMock->method('execute')
                  ->will($this->throwException(new InvalidEmailException('Invalid email format')));

      $controller = new RegisterUserController($useCaseMock);
      $response = $controller->register($requestData);

      var_dump($response);  

      $this->assertStringContainsString('Invalid email format', $response);
    }

    public function testEmailAlreadyInUse()
    {
        $requestData = [
            'name' => 'John Doe',
            'email' => 'omar.rojas@example.com',  //email en uso
            'password' => 'Password123!'
        ];

        $useCaseMock = $this->createMock(RegisterUserUseCase::class);
        $useCaseMock->method('execute')
                    ->will($this->throwException(new UserAlreadyExistsException('Email already in use')));

        $controller = new RegisterUserController($useCaseMock);
        $response = $controller->register($requestData);

        var_dump($response);  
        $this->assertStringContainsString('Email already in use', $response);
    }

    public function testWeakPassword()
    {
        // contraseña débil
        $requestData = [
            'name' => 'John Doe',
            'email' => 'omar.rojas@example.com',
            'password' => 'weak' 
        ];

        $useCaseMock = $this->createMock(RegisterUserUseCase::class);
        $useCaseMock->method('execute')
                    ->will($this->throwException(new WeakPasswordException('Password is too weak')));

        $controller = new RegisterUserController($useCaseMock);
        $response = $controller->register($requestData);

        var_dump($response); 
        $this->assertStringContainsString('Weak password', $response);
    }




    

}
