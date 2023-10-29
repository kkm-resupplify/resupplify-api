<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserIsNotMemberOfThisCompanyException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_IS_NOT_MEMBER_OF_THIS_COMPANY;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.userIsNotMemberOfThisCompany');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
