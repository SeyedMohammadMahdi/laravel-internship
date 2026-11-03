<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductFilterService
{

    public function filter(?string $name=null, ?string $category = null, ?bool $is_available = null, ?float $min_price = null, ?float $max_price = null): array{
        $table = (new Product())->getTable();
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

        $output = $query->get();
        if($output->isEmpty()){
            return [
                "message" => "No products found.",
                "status_code" => 404
            ];
        }
        $response = [];
        foreach($output as $item){
            $response[] = [
                "id" => $item->id,
                "name" => $item->name,
                "category" => $item->category,
                "stock" => $item->stock,
                "price" => $item->price,
            ];
        }
        return $response;
    }
}
