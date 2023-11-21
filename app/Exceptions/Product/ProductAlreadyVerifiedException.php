<?php

namespace App\Exceptions\Product;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class ProductAlreadyVerifiedException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::PRODUCT_ALREADY_VERIFIED;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.productAlreadyVerified');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
