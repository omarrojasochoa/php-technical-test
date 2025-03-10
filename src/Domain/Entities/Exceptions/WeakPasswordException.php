<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions;

class WeakPasswordException extends \InvalidArgumentException
{
    protected $message = 'Password is too weak';
}
