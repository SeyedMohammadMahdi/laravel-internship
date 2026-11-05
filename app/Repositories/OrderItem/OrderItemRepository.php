<?php

namespace App\Repositories\OrderItem;

use Illuminate\Support\Facades\DB;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    private string $table;

    function __construct(string $table){
        $this->table = $table;
    }
    public function create(array $items, int $orderId){
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                "order_id" => $orderId,
                "product_id" => $item["id"],
                "quantity" => $item["amount"],
            ];
        }
        return DB::table($this->table)->insert($rows);
    }

}
