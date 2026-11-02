<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;
    public function __construct(){
        $this->productService = new ProductService();
    }
    public function create(Request $request): JsonResponse{
        $body  = $request->all();

        return response()->json($this->productService->create($body["name"], $body["price"], $body['stock'], $body["category"]));
    }
}
