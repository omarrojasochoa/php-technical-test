<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities;
use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\InvalidEmailException;

class Email
{
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          var_dump("Invalid email format detected"); // Depuración
            throw new InvalidEmailException('Invalid email format');
        }

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
