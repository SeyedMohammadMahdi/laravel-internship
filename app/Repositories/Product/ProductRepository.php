<?php

namespace App\Repositories\Product;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function all(int $page = 1, int $perPage = 10){
        $paginated = Cache::tags(["products"])->remember("products_{$page}_{$perPage}", 600, function () use ($page, $perPage) {
            $paginated = DB::table($this->table)->paginate($perPage, ["*"], "page", $page);
            Log::info("_______________________________ CACHE MISSED _________________________________");
            return [
                "data"=>ProductResource::collection($paginated)->resolve(),
                "last_page"=>$paginated->lastPage(),
                "current_page"=>$paginated->currentPage(),
                "total"=>$paginated->total(),
                "per_page"=>$paginated->perPage(),
            ];
        });

        return $paginated;
    }

    public function find(int $id): array|null
    {
        return Cache::tags(["products"])->remember("products_{$id}", 600, function () use ($id) {
            $product = DB::table($this->table)->find($id);
            Log::info("____________________________________ CACHE MISSED _________________________________");
            if($product === null) {
                return null;
            }
            return new ProductResource($product)->resolve();
        });
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

    public function update($id, ?string $name=null, ?string $category=null, ?float $price=null, ?int $stock = null, ?string $path=null){
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

        if($path !== null){
            $updates['path'] = $path;
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
