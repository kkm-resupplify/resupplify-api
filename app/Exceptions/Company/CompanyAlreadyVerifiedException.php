<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class CompanyAlreadyVerifiedException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::COMPANY_ALREADY_VERIFIED;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.companyAlreadyVerified');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
