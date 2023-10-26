<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserInviteCodeNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::CANT_DELETE_USER;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userIsNotMemberOfThisCompany');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
