<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class CompanyNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::COMPANY_NOT_FOUND;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.companyNotFound');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
