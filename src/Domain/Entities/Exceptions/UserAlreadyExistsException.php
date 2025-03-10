<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions;

class UserAlreadyExistsException extends \InvalidArgumentException
{
    protected $message = 'Email already in use';
}
