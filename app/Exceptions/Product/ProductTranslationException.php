<?php

namespace App\Exceptions\Product;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class ProductTranslationException extends BasicException
{
  protected function init()
  {
    $this->errorCode = CustomErrorCodes::PRODUCT_TRANSLATION;
    $this->errorHttpCode = Response::HTTP_NOT_FOUND;
    $this->errorMsg = $this->__('messages.exception.productTransaction');

    $errorData = $this->getErrorData();

    if (isset($errorData)) {
      $this->errorData = $errorData;
    }
  }
}
