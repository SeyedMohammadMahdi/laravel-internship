<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreationRequest;
use App\Http\Requests\Product\ProductDeleteRequest;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Services\Product\ProductCRUDService;
use App\Services\Product\ProductFilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductCRUDService $productService;
    private ProductFilterService $productFilterService;
    public function __construct(){
        $this->productService = new ProductCRUDService();
        $this->productFilterService = new ProductFilterService();
    }
    public function createProduct(ProductCreationRequest $request): JsonResponse{
        $body  = $request->validated();
        $resp = $this->productService->create($body["name"], $body["price"], $body['stock'], $body["category"]);
        return response()->json($resp, $resp["status_code"]);
    }

    public function getProducts(Request $request, int $id =null): JsonResponse{
        return response()->json($this->productService->get($id));
    }

    public function deleteProduct(ProductDeleteRequest $request, int $id = null): JsonResponse{
        $resp = $this->productService->delete($id);
        return response()->json($resp, $resp["status_code"]);
    }

    public function updateProduct(Request $request, int $id = null): JsonResponse{
        $body = $request->json()->all();
        $resp = $this->productService->update($body["data"], $body["id"]);
        return response()->json($resp, $resp["status_code"]);
    }

    public function filterProducts(ProductFilterRequest $request): JsonResponse{
        $body = $request->validated();
        return response()->json($this->productFilterService->filter($body["name"] ?? null, $body["category"] ?? null, $body["is_available"] ?? null, $body["min_price"] ?? null, $body["max_price"] ?? null));
    }
}
