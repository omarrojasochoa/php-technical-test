<?php

namespace Orojaso\PhpTechnicalTest\Infrastructure\Controller;

use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserUseCase;
use Orojaso\PhpTechnicalTest\Domain\UseCases\RegisterUserRequest;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\UserAlreadyExistsException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\InvalidEmailException;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\WeakPasswordException;
use Orojaso\PhpTechnicalTest\Infrastructure\EventDispatcher;
use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEventListener;
use Orojaso\PhpTechnicalTest\Domain\Entities\Email;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Name;
use Orojaso\PhpTechnicalTest\Domain\ValueObjects\Password;
use Orojaso\PhpTechnicalTest\Domain\Entities\User;

class RegisterUserController
{
    private $useCase;

    public function __construct(RegisterUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

   
    public function register($requestData)
    {
      try {
          // Crear el DTO y ejecutar uso
          $request = new RegisterUserRequest(
              $requestData['name'],
              $requestData['email'],
              $requestData['password']
          );

          $this->useCase->execute($request);

          return json_encode(['message' => 'User registered successfully']);
      } catch (InvalidEmailException $e) {
          var_dump("Caught InvalidEmailException: " . $e->getMessage());
          return json_encode(['error' => 'Invalid email format']);
      } catch (UserAlreadyExistsException $e) {
          return json_encode(['error' => 'Email already in use']);
      } catch (WeakPasswordException $e) {
          return json_encode(['error' => 'Weak password']);
      } catch (\Exception $e) {
          return json_encode(['error' => 'An unexpected error occurred']);
      }
    }

}
