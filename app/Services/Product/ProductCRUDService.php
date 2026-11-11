<?php

namespace App\Services\Product;

use App\DTOs\Product\ProductImageUploadDTO;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProductCRUDService
{

    private ProductRepositoryInterface $productRepository;
    public function __construct()
    {
        $this->productRepository = app(ProductRepositoryInterface::class);
    }

    public function create(string $name = null, float $price = null, int $stock = null, string $category = null): array{
        if ($name === null || $price === null || $stock === null || $category === null) {
            return [
                [
                'status' => false,
                'message'=> "all fields are required. make sure to include name,price,stock,category"
                ],
                'status_code'=> 400
            ];
        }

        $productCreated = $this->productRepository->create($name, $category, $price, $stock);
        if (is_int($productCreated)){
            return [
                "status_code"=> 201,
                "message"=> "product created",
                "id"=> $productCreated
            ];
        }
        return [
            "status_code"=> 400,
            "message"=> "product not created"
        ];
    }

    public function get(?int $id = null, int $page = 1, int $perPage = 10): array{
        if ($id == null){
            $output = $this->productRepository->all(page: $page, perPage: $perPage);
            if($output->count() === 0){
                return [
                    "message" => "No product found",
                    "status_code" => 404,
                    "last_page"=> $output->lastPage(),
                ];
            }
            return [
                "message" => "Products found",
                "status_code" => 200,
                "data" => $output->getCollection()->toArray(),
                "last_page" => $output->lastPage(),
                "current_page" => $output->currentPage(),
                "total" => $output->total(),
                "per_page" => $output->perPage(),
            ];
        }
        $product = $this->productRepository->find($id);
        if($product == null){
            return [
                "message"=> "Product not found",
                "status"=> false,
                "status_code"=> 404,
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

    public function uploadProductImage(ProductImageUploadDTO $productImageUploadDTO): array{
        $product = $this->productRepository->find($productImageUploadDTO->productId);
        if ($product->path !== null){
            Storage::disk('public')->delete($product->path);
        }
        $fileName = uniqid() . '_' . hash_file('sha256',$productImageUploadDTO->file->getRealPath()) . '.' . $productImageUploadDTO->file->getClientOriginalExtension();
        $path = $productImageUploadDTO->file->storeAs('uploads', $fileName, 'public');
        $productImageDTO = new ProductImageUploadDTO(
            productId: $product->id,
            file: $productImageUploadDTO->file,
            path: $path,
        );
        $updated = $this->productRepository->update(id: $productImageDTO->productId,  path: $path);
        if ($updated === 0){
            return [
                "message"=> "Product image upload failed",
                "status_code"=> 400,
            ];
        }
        $url = Storage::disk('public')->url($path);
        return [
            "message"=> "Product image upload success",
            "status_code"=> 200,
            "path"=> $url,
        ];

    }
}
