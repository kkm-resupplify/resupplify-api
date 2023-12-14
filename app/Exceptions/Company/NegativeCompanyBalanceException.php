<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class NegativeCompanyBalanceException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::NEGATIVE_COMPANY_BALANCE;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.negativeCompanyBalanceException');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
