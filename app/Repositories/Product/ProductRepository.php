<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function all(int $page = 1, int $perPage = 10): LengthAwarePaginator{
//        $h =  DB::table($this->table)->paginate($perPage, ["*"], "page", $page);
//        $h->lastPage();
//        $h->perPage()
//        $h->toArray()
        return DB::table($this->table)->paginate($perPage, ["*"], "page", $page);
    }

    public function find(int $id): \stdClass|null
    {
        return DB::table($this->table)->find($id);
    }

    public function create(string $name, string $category, float $price, int $stock): int|bool
    {
        try {
             return DB::table($this->table)->insertGetId([
                'name' => $name,
                'category' => $category,
                'price' => $price,
                'stock' => $stock,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
//            if (is_int($createdProduct)) {
//                return [
//                    "message" => "Product created.",
//                    "status_code" => 201,
//                    "id" => $createdProduct
//                ];
//            }
//            return [
//                "message" => "Product not created.",
//                "status_code" => 400
//            ];
        }catch (\Exception $exception){
            return false;
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

    function getMultipleByIds(array $ids)
    {
        return DB::table($this->table)->whereIn("id", $ids)->get();
    }
}
