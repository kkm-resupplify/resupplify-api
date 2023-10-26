<?php

namespace App\Exceptions\User;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_NOT_FOUND;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userNotFound');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
