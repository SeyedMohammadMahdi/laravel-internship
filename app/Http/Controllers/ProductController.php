<?php

namespace App\Http\Controllers;

use App\Services\Discount\DiscountHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private ProductService $productService;
    private DiscountHandler $discountHandler;
    public function __construct()
    {
        $this->productService = new ProductService();
        $this->discountHandler = new DiscountHandler();
    }

    public function getProducts(int $id = null): JsonResponse {
        if ($id != null) {
            return response()->json($this->productService->getProducts($id));
        }
        return response()->json($this->productService->getProducts());
    }

    public function filterProducts(Request $request): JsonResponse {
        $category = $request->query('category', null);
        $available = $request->query('isAvailable', null);

        $isAvailable = match ($available) {
            null => null,
            'true' => true,
            'false' => false
        };

        return response()->json($this->productService->filterProducts($category, $isAvailable));
    }

    public function calculateDiscount(Request $request): JsonResponse {
        $body  = $request->json()->all();
        $validated = $request->validate(
            [
                "type"=> "required|integer|min:0|max:2",
                "price"=> "required|numeric",
                "discount"=> "numeric|nullable",
            ]
        );

        return response()->json($this->discountHandler->calculateDiscount($validated['type'], $validated['price'], $validated['discount']));
    }
}
