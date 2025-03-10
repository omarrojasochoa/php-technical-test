<?php

namespace Orojaso\PhpTechnicalTest\Infrastructure;

use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEvent;
use Orojaso\PhpTechnicalTest\Domain\Events\UserRegisteredEventListener;

class EventDispatcher
{
    private $listeners = [];

    public function addListener($eventName, $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener->handle($event);
            }
        }
    }
}
