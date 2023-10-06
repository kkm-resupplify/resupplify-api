<?php

namespace App\Exceptions\General;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyExistsException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_ALREADY_EXISTS;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userAlreadyExists');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
