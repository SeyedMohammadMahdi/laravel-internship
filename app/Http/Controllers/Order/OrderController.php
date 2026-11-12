<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderCancelRequest;
use App\Http\Requests\Order\OrderCreateRequest;
use App\Http\Requests\Order\OrderGetRequest;
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
    public function create(OrderCreateRequest $request): JsonResponse {
        $order = $request->orderDTO;
        return response()->json($this->orderService->createOrder($order->products, $order->customerName));

    }

    public function getAll(OrderGetRequest $request): JsonResponse {
        $page = $request->input("page", 1);
        $limit = $request->input("limit", 1);
        $resp = $this->orderService->getAll($page, $limit);
        return response()->json($resp, $resp["status_code"]);
    }

    public function cancelOrder(OrderCancelRequest $request): JsonResponse {
        $orderId = $request->id;
        return response()->json($this->orderService->cancelOrder($orderId));
    }
}
