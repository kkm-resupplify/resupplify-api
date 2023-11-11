<?php

namespace App\Exceptions\Filter;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class FilterNotAllowedException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::FILTER_NOT_ALLOWED;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.filterNotAllowed');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
