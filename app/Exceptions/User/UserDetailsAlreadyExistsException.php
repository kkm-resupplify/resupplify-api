<?php

namespace App\Exceptions\User;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserDetailsAlreadyExistsException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_DETAILS_ALREADY_EXISTS;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userDetailsExists');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
