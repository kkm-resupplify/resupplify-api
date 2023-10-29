<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class CantCreateUserInvitationRoleException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::CANT_CREATE_USER_INVITATION_ROLE;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.cantCreateUserInvitationRole');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}

