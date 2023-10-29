<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UserDoesNotHaveCompanyException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::USER_DOES_NOT_HAVE_COMPANY;
        $this->errorHttpCode = Response::HTTP_NOT_FOUND;
        $this->errorMsg = $this->__('messages.exception.userDoesNotHaveCompany');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
