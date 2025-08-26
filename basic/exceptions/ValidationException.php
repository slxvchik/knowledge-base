<?php

namespace app\exceptions;

class ValidationException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 422);
    }
}