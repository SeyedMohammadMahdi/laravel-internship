<?php

namespace App\Repositories\Order;
interface OrderRepositoryInterface
{
    public function create(array $items, string $customerName, string $status, float $totalAmount);

    public function getAll();

    public function OrderWithItems();


//    public function paginate(int $page, int $limit);

}
