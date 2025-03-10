<?php

namespace Orojaso\PhpTechnicalTest\Domain\ValueObjects;


use Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions\WeakPasswordException;

class Password
{
    private $password;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new WeakPasswordException('Password must be at least 8 characters');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one number');
        }

        if (!preg_match('/[\W_]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one special character');
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
