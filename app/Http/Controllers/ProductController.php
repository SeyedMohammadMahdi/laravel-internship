<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;
class ProductController extends Controller
{
    private ProductService $productService;
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function getProducts(): JsonResponse {
        return response()->json($this->productService->getProducts());
    }
}
