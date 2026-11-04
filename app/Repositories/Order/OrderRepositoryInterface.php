<?php

namespace App\Repositories\Order;
interface OrderRepositoryInterface
{
    public function create(int $productId, string $customerName, string $status, float $totalAmount);

    public function getAll();

    public function getById($id);

//    public function paginate(int $page, int $limit);

}
