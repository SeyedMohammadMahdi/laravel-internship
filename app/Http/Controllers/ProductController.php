<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private ProductService $productService;
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function getProducts(int $id = null): JsonResponse {
        if ($id != null) {
            return response()->json($this->productService->getProducts($id));
        }
        return response()->json($this->productService->getProducts());
    }
}
