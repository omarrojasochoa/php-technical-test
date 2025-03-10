<?php

namespace Orojaso\PhpTechnicalTest\Domain\Events;

class UserRegisteredEventListener
{
    public function handle(UserRegisteredEvent $event)
    {
        $user = $event->getUser();

        echo "Welcome, " . $user->getName() . "! You have successfully registered.";
    }
}
