<?php

namespace App\Repositories\Order;

use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class OrderRepository implements OrderRepositoryInterface
{
    private string $table;
    private string $order_item_table;
    public function __construct(string $table, string $order_item_table)
    {
        $this->table = $table;
        $this->order_item_table = $order_item_table;
    }

    public function create(array $items, string $customerName, string $status, float $totalAmount)
    {
        $order_created = DB::table($this->table)->insertGetId([
            'customer_name' => $customerName,
            'status' => $status,
            'total_amount' => $totalAmount,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $items_created = true;
        foreach ($items as $item) {
            $order_item_created = DB::table($this->order_item_table)->insert([
                "order_id" => $order_created,
                "product_id" => $item["id"],
                "quantity" => $item["amount"],
            ]);
            $items_created = $items_created && $order_item_created;
        }

        return  is_int($order_created) and $items_created;
    }

    public function OrderWithItems(){
        return DB::table($this->table)->join("products", "products.id", "=", "$this->table.product_id")->get();
    }

    public function getAll(){
        $orders = DB::table($this->table)->get();
        $order_ids = $orders->pluck("id");
        $items = DB::table("order__items")->join("products", "products.id", "=", "order__items.product_id")
            ->whereIn("order_id", $order_ids)
            ->get()->groupBy("order_id");

        $orders->transform(function ($order) use ($items) {
            $order->products = $items
                ->get($order->id, collect())
                ->values();

            return $order;
        });

        return $orders;
    }
}
