<?php

namespace App\Exceptions\Order;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class OrderNotEnoughProductException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::ORDER_NOT_ENOUGH_PRODUCTS;
        $this->errorHttpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->errorMsg = $this->__('messages.exception.order.product');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
