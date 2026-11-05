<?php

namespace App\Repositories\Order;
interface OrderRepositoryInterface
{
    public function create(array $items, string $customerName, string $status, float $totalAmount);

    public function OrderWithItems();

    public function getAllPaginated(int $page = 1, int $perPage = 10);


//    public function paginate(int $page, int $limit);

}
