<?php

namespace App\Repositories\Order;

use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function create(int $productId, string $customerName, string $status, float $totalAmount)
    {
        return DB::table($this->table)->insert([
            'product_id' => $productId,
            'customer_name' => $customerName,
            'status' => $status,
            'total_amount' => $totalAmount,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function getAll(){
        return DB::table($this->table)->get();
    }

    public function getById($id){
        return DB::table($this->table)->find($id);
    }

}
