<?php

namespace Orojaso\PhpTechnicalTest\Domain\DTO;

class UserResponseDTO
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'message' => $this->message
        ];
    }
}
