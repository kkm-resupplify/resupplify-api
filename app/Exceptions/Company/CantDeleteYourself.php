<?php

namespace App\Exceptions\Company;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class CantDeleteYourself extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::CANT_DELETE_YOURSELF;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.cantDeleteYourself');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
