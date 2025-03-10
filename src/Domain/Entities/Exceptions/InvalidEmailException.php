<?php

namespace Orojaso\PhpTechnicalTest\Domain\Entities\Exceptions;

class InvalidEmailException extends \InvalidArgumentException
{
    protected $message = 'Invalid email format';
}
