<?php

namespace App\DTOs\Order;

readonly class OrderCreateDTO
{
    public function __construct(
        public string $customerName,
        public array $products,
    ){}

    public function toArray(): array {
        return [
            'customerName' => $this->customerName,
            'products' => $this->products,
        ];
    }
}
