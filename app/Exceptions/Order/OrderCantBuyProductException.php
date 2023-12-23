<?php

namespace App\Exceptions\Order;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class OrderCantBuyProductException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::ORDER_CANT_BUY_PRODUCT;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.order.cantBuyCompanyProduct');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
