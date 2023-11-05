<?php

namespace App\Exceptions\Warehouse;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class WarehouseNotFoundException extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::WAREHOUSE_NOT_FOUND;
        $this->errorHttpCode = Response::HTTP_NOT_FOUND;
        $this->errorMsg = $this->__('messages.exception.warehouseNotFound');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
