<?php

namespace App\Repositories\OrderItem;
interface OrderItemRepositoryInterface {

    public function create(array $items, int $orderId);
    public function getItemsByOrderId(array $orderIds);
}
