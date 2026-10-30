<?php
namespace App\Services\Discount;
class DiscountHandler {
    public function calculateDiscount(int $type, float $price, float $discount = null): array{
        if($type === 0){
            return ["final-price"=>(float)$price, "status"=>true];
        }

        $discountCalculator = match ($type){
            1 => new PercentDiscount(),
            2 => new AmountDiscount(),
            default => null
        };

        if (is_null($discountCalculator)) {
            return ["message"=>"invalid discount type", "status"=>false];
        }

        return $discountCalculator->calculatePrice($discount, $price);
    }
}
