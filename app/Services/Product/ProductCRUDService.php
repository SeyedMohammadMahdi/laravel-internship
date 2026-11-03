<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductCRUDService
{

    private ProductRepositoryInterface $productRepository;
    public function __construct()
    {
        $this->productRepository = app(ProductRepositoryInterface::class);
    }

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

        return $this->productRepository->create($name, $category, $price, $stock);
    }

    public function get(?int $id = null): array{
        if ($id == null){
//            $products = Product::all();
//            $list = [];
//            foreach ($products as $product){
//                $list[] = [
//                    "id"=> $product->id,
//                    "name"=> $product->name,
//                    "price"=> $product->price,
//                    "stock"=> $product->stock,
//                    "category"=> $product->category,
//                ];
//            }
//            return $list;
            $output = $this->productRepository->all();
            if($output->count() === 0){
                return [
                    "message" => "No product found",
                    "status_code" => 404
                ];
            }
            return [
                "message" => "Products found",
                "status_code" => 200,
                "data" => $output->toArray()
            ];
        }
        $product = $this->productRepository->find($id);
        if($product == null){
            return [
                "message"=> "Product not found",
                "status"=> false,
            ];
        }
        return [
            "message"=> "Product found",
            "status_code" => 200,
            "data" => $product
        ];
    }

    public function delete(int $id = null): array{
        if ($id == null){
            return [
                "message"=> "Product not found",
                "status_code"=> 404,
            ];
        }
        $deleted = $this->productRepository->delete($id);
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

    public function update(array $data, int $id = null): array{
        if ($id == null){
            return [
                "message"=> "Product id should not be empty",
                "status_code"=> 400,
            ];
        }

        $fields = new Product()->getFillable();
        $errorList = [];
        $update_list = [];
        foreach ($data as $key => $value) {
            if(in_array($key, $fields)){
                $update_list[$key] = $value;
                continue;
            }
            $errorList[] = $key.': unknown field';
        }
        if (!empty($errorList)){
            return [
                "message"=> $errorList,
                "status_code"=> 400,
            ];
        }
        $count = $this->productRepository->update($id, ...$update_list);
        if ($count === 0){
            return [
                "message"=> "Product not found",
                "status_code"=> 404,
            ];
        }
        return [
            "message"=> "Product updated",
            "status_code"=> 200,
        ];
    }
}
