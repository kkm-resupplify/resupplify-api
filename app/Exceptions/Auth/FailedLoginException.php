<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class FailedLoginException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::LOGIN_FAILED;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.failedLogin');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
