<?php

namespace Orojaso\PhpTechnicalTest\Domain\ValueObjects;

class Name
{
    private $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException('Name must be at least 3 characters long');
        }

        if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
            throw new \InvalidArgumentException('Name must contain only letters and spaces');
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
