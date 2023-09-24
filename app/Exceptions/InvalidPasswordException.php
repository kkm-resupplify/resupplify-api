<?php

namespace App\Exceptions;

use Exception;

class InvalidPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct(trans('messages.wrongPassword'), 2137);
    }
}
