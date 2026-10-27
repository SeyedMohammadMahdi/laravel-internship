<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ProductService
{
    private array $products;
    public function __construct()
    {
        $this->products = [
            [
                "id"=>1,
                "name"=>"cheese",
                "stock"=>10,
                "price"=>100,
                "category"=>"milk-products",
            ],[
                "id"=>2,
                "name"=>"orange",
                "stock"=>5,
                "price"=>80,
                "category"=>"fruit",
            ],[
                "id"=>3,
                "name"=>"soap",
                "stock"=>20,
                "price"=>150,
                "category"=>"cleaning-products",
            ],[
                "id"=>4,
                "name"=>"chess",
                "stock"=>50,
                "price"=>300,
                "category"=>"entertainment-products",
            ],
        ];
    }

    public function getProducts(int $id = null): array{
        if ($id != null) {
            foreach ($this->products as $product) {
                if ($product["id"] == $id) {
                    return $product;
                }
            }
            return [
                "message" => "Product not found",
            ];

        }
        return $this->products;
    }
}
