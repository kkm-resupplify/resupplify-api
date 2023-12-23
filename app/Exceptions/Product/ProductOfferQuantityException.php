<?php

namespace App\Exceptions\Product;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferQuantityException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::PRODUCT_OFFER_QUANTITY;
        $this->errorHttpCode = Response::HTTP_NOT_FOUND;
        $this->errorMsg = $this->__('messages.exception.productOfferQuantity');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
