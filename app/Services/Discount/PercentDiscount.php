<?php
namespace App\Services\Discount;
class PercentDiscount implements discountInterface {
    public function calculatePrice(float $discount, float $price): array {
        return match (true) {
            $discount <= 100 => ["final-price"=>(float)$price - ($price*$discount/100), "status"=>true],
            $discount >= 100 => ["message"=>"the discount percentage should be less than 100%", "status"=>false],
        };
    }
}
