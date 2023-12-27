<?php

namespace App\Http\Controllers\Portal\Order;

use App\Http\Dto\Order\OrderDto;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Http\Dto\Order\OrderStatusDto;

class OrderController extends Controller
{
    public function store(OrderDto $request, OrderService $service)
    {
        return $this->ok($service->createOrder($request));
    }

    public function getListOfOrdersPlacedByAuthCompany(OrderService $service)
    {
        return $this->ok($service->getListOfOrdersPlacedByAuthCompany());
    }

    public function getListOfOrdersBoughtByAuthCompany(OrderService $service)
    {
        return $this->ok($service->getListOfOrdersBoughtByAuthCompany());
    }

    public function changeOrderStatus(OrderService $service, OrderStatusDto $request)
    {
        return $this->ok($service->changeOrderStatus($request));
    }
}
