<?php

namespace App\Services\Discount;
interface discountInterface {
    public function calculatePrice(float $discount, float $price): array;
}
