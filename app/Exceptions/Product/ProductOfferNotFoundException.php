<?php

namespace App\Exceptions\Product;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class ProductOfferNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::PRODUCT_OFFER_NOT_FOUND;
        $this->errorHttpCode = Response::HTTP_NOT_FOUND;
        $this->errorMsg = $this->__('messages.exception.productOfferNotFound');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
