<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::UNAUTHORIZED;
        $this->errorHttpCode = Response::HTTP_UNAUTHORIZED;
        $this->errorMsg = $this->__('messages.exception.unauthorized');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
