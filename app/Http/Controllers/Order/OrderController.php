<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private OrderService $orderService;
    public function __construct(){
        $this->orderService = app(OrderService::class);
    }
    public function create(Request $request): JsonResponse {
        $body = $request->json()->all();
        return response()->json($this->orderService->createOrder($body["product_id"], $body["customer_name"], $body["count"]));

    }
}
