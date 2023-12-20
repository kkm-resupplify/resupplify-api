<?php

namespace App\Services\Order;


use App\Services\BasicService;
use App\Helpers\PaginationTrait;
use App\Http\Dto\Order\OrderDto;

class OrderService extends BasicService
{
    use PaginationTrait;

    public function createOrder(OrderDto $request)
    {

    }
}
