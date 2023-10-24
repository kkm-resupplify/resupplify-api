<?php

namespace App\Exceptions\User;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyHaveCompany extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_ALREADY_HAVE_COMPANY;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userAlreadyHaveCompany');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
