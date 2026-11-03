<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductFilterService
{

    private ProductRepositoryInterface $productRepository;

    public function __construct() {
        $this->productRepository = app(ProductRepositoryInterface::class);
    }
    public function filter(?string $name=null, ?string $category = null, ?bool $is_available = null, ?float $min_price = null, ?float $max_price = null): array{

        $output = $this->productRepository->filter($name, $category, $is_available, $min_price, $max_price);
        if($output->isEmpty()){
            return [
                "message" => "No products found.",
                "status_code" => 404,
                "output" => $name
            ];
        }

        return $output->toArray();
    }
}
