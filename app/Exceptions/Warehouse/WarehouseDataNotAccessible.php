<?php

namespace App\Exceptions\Warehouse;

use App\Exceptions\BasicException;
use App\Exceptions\CustomErrorCodes;
use Symfony\Component\HttpFoundation\Response;

class WarehouseDataNotAccessible extends BasicException
{
    protected function init()
    {
        $this->errorCode = CustomErrorCodes::WAREHOUSE_DATA_NOT_ACCESSIBLE;
        $this->errorHttpCode = Response::HTTP_NOT_FOUND;
        $this->errorMsg = $this->__('messages.exception.warehouseDataNotAccessible');

        $errorData = $this->getErrorData();

        if (isset($errorData)) {
            $this->errorData = $errorData;
        }
    }
}
