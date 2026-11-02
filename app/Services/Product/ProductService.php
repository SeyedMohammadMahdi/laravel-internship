<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService
{
    public function create(string $name = null, float $price = null, int $stock = null, string $category = null): array{
        if ($name == null || $price == null || $stock == null || $category == null) {
            return [
                [
                'status' => false,
                'message'=> "all fields are required. make sure to include name,price,stock,category"
                ],
                'status_code'=> 400
            ];
        }
        $product = Product::create([
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'category' => $category
        ]);
        return [
            "status" => true,
            "message"=> "Product created",
            'status_code'=> 200,
            "data"=> [
                "name"=> $name,
                "id"=> $product->id,
            ]
        ];
    }
}
