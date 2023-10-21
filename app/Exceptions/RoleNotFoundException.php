<?php

namespace App\Exceptions\General;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class RoleNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::VALIDATION_FAILED;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.roleNotFound');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
