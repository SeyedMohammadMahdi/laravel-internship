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

    public function get(int $id = null): array{
        if ($id == null){
            $products = Product::all();
            $list = [];
            foreach ($products as $product){
                $list[] = [
                    "id"=> $product->id,
                    "name"=> $product->name,
                    "price"=> $product->price,
                    "stock"=> $product->stock,
                    "category"=> $product->category,
                ];
            }
            return $list;
        }
        $product = Product::find($id);
        if($product == null){
            return [
                "message"=> "Product not found",
                "status"=> false,
            ];
        }
        return [
            "id"=> $product->id,
            "name"=> $product->name,
            "price"=> $product->price,
            "stock"=> $product->stock,
            "category"=> $product->category,
        ];
    }

    public function delete(int $id = null): array{
        if ($id == null){
            return [
                "message"=> "Product not found",
                "status_code"=> 404,
            ];
        }
        $deleted = Product::destroy($id);
        if ($deleted === 0) {
            return [
                "message"=> "Product not found",
                "status_code"=> 404,
            ];
        }
        return [
            "message"=> "product deleted",
            "status_code"=> 200,
        ];
    }
}
