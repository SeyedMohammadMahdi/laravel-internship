<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;
    private ProductRepositoryInterface $productRepository;
    private OrderItemRepositoryInterface $orderItemRepository;

    public function __construct() {
        $this->orderRepository = app(OrderRepositoryInterface::class);
        $this->productRepository = app(ProductRepositoryInterface::class);
        $this->orderItemRepository = app(OrderItemRepositoryInterface::class);
    }
    public function createOrder(array $items, string $customerName) {
        $product_ids = array_column($items, 'id');
        $products_info = $this->productRepository->getMultipleByIds($product_ids);
        $products_infoByKey = $products_info->keyBy('id');
        if ($products_infoByKey->isEmpty()) {
            return [
                "message"=>"no products found",
                "status_code"=>404,
            ];
        }
        $errorList = [];
        $totalAmount = 0;
        $totalPrice = 0;
        foreach($items as $item){
            $product = $products_infoByKey->get($item['id']);
            if(!$product) {
                $errorList[] = [
                    "message" => "no product found with id " . $item['id'],
                    "status_code" => 404,
                ];
                continue;
            }
            if ($product->stock < $item['amount']) {
                $errorList[] = [
                    "message" => "stock is out of stock " . $item['id'] . ": " . $item['amount'],
                    "status_code" => 400,
                ];
            }
            $totalAmount += $item['amount'];
            $totalPrice += $item['amount'] * $product->price;
        }

        if (count($errorList) > 0) {
            return [
                "message"=>"error while creating order",
                "status_code"=>400,
                "errors"=> $errorList
            ];
        }

        try {
            DB::transaction(function () use ($items, $products_infoByKey,$customerName, $totalPrice) {
                $orderCreated = $this->orderRepository->create($items, $customerName, "completed", $totalPrice);
                if (!is_int($orderCreated)) {
                    throw new \Exception("error while creating order");
                }
                $itemsCreated = $this->orderItemRepository->create($items, $orderCreated);
                if ($itemsCreated === false){
                    throw new \Exception("error while creating order");
                }

                foreach($items as $item){
                    $product = $products_infoByKey->get($item['id']);
                    $updates = $this->productRepository->update($item['id'], null, null, null, $product->stock-$item["amount"]);
                    if($updates === 0 || $updates > 1){
                        throw new \Exception("error while updating product");
                    }
                }
            });
        } catch (\Exception $e ) {
            return [
                "message" => "Order not created",
                "status_code" => 400,
                "error" => $e->getMessage()
            ];
        }
        $data = [];
        foreach ($products_info as $product) {
            $data[] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
            ];
        }
        return [
            "message" => "Order created",
            "status_code" => 201,
            "total_price"=> $totalAmount * $product->price,
            "data" => $data,
        ];

    }

    public function getAll(int $page = 1, int $count=10){
        $orders = $this->orderRepository->getAll();
        return $orders->toArray();
    }
}
