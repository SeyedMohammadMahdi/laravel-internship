<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function all(): Collection{
        $query = DB::table($this->table);
        return $query->get();
    }

    public function find(int $id): \stdClass|null
    {
        return DB::table($this->table)->find($id);
    }

    public function create(string $name, string $category, float $price, int $stock): array
    {
        try {
            $is_created = DB::table($this->table)->insert([
                'name' => $name,
                'category' => $category,
                'price' => $price,
                'stock' => $stock,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($is_created) {
                return [
                    "message" => "Product created.",
                    "status_code" => 201
                ];
            }
            return [
                "message" => "Product not created.",
                "status_code" => 400
            ];
        }catch (\Exception $exception){
            return [
                "message" => $exception->getMessage(),
                "status_code" => 500
            ];
        }
    }

    public function update($id, ?string $name=null, ?string $category=null, ?float $price=null, ?int $stock = null){
        $updates = [];
        if($name !== null){
            $updates['name'] = $name;
        }
        if($category !== null){
            $updates['category'] = $category;
        }
        if($price !== null){
            $updates['price'] = $price;
        }
        if($stock !== null){
            $updates['stock'] = $stock;
        }
        $updates['updated_at'] = now();
        return DB::table($this->table)->where('id', $id)->update($updates);
    }

    public function delete(int $id){
        return DB::table($this->table)->where('id', $id)->delete();
    }

    public function filter(?string $name=null, ?string $category = null, ?bool $is_available = null, ?float $min_price = null, ?float $max_price = null){
        $table = new Product()->getTable();
        $query = DB::table($table);
        if($name){
            $query->where("name", "like", "%".$name."%");
        }
        if($category){
            $query->where("category", "like", "%".$category."%");
        }
        if($is_available){
            $query->where("stock", ">", 0);
        }
        if($min_price){
            $query->where("price", ">=", $min_price);
        }
        if($max_price){
            $query->where("price", "<=", $max_price);
        }
        return $query->get();
    }
}
