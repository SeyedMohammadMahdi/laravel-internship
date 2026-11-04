<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct() {
        $this->orderRepository = app(OrderRepositoryInterface::class);
        $this->productRepository = app(ProductRepositoryInterface::class);
    }
    public function createOrder(int $productId, string $customerName, int $totalAmount) {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            return [
                "message" => "Product not found",
                "status_code" => 404,
            ];
        }

        if ($product->stock < $totalAmount) {
            return [
                "message" => "Product out of stock",
                "status_code" => 400,
            ];
        }


        try {
            DB::transaction(function () use ($product, $productId, $customerName, $totalAmount) {
                $isCreated = $this->orderRepository->create($productId, $customerName, "completed", $totalAmount);
                $updated = $this->productRepository->update($productId, null, null, null, $product->stock-$totalAmount);
                if (($updated > 1 or $updated === 0) or $isCreated === false) {
                    throw new \RuntimeException("order cannot be processed");
                }

                return true;
            });
        } catch (\Exception $e ) {
            return [
                "message" => "Order not created",
                "status_code" => 400,
                "error" => $e->getMessage()
            ];
        }

        return [
            "message" => "Order created",
            "status_code" => 201,
            "total_price"=> $totalAmount * $product->price,
            "data" => [
                "id" => $productId,
                "name"=>$product->name,
                "price"=>$product->price,
            ],
        ];

    }

    public function getAll(int $page = 1, int $count=10){
        $orders = $this->orderRepository->getAll();
        return $orders->toArray();
    }
}
