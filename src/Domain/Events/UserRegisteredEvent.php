<?php

namespace Orojaso\PhpTechnicalTest\Domain\Events;

class UserRegisteredEvent
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
