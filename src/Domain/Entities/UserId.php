<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities;

class UserId
{
    private $id;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be a positive integer');
        }

        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
