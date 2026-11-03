<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreationRequest;
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
    public function createProduct(ProductCreationRequest $request): JsonResponse{
        $body  = $request->validated();
        $resp = $this->productService->create($body["name"], $body["price"], $body['stock'], $body["category"]);
        return response()->json($resp, $resp["status_code"]);
    }

    public function getProducts(Request $request, int $id =null): JsonResponse{
        return response()->json($this->productService->get($id));
    }

    public function deleteProduct(Request $request, int $id = null): JsonResponse{
        $resp = $this->productService->delete($id);
        return response()->json($resp, $resp["status_code"]);
    }

    public function updateProduct(Request $request, int $id = null): JsonResponse{
        $body = $request->json()->all();
        $resp = $this->productService->update($body["data"], $body["id"]);
        return response()->json($resp, $resp["status_code"]);
    }
}
