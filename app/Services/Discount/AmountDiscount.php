<?php
namespace App\Services\Discount;

class AmountDiscount implements discountInterface {
    public function calculatePrice(float $discount, float $price): array
    {
        return match(true){
            $discount >0 and $discount <= $price => ["final-price" => $price-$discount, "status"=>true],
            default => ["message"=>"discount should less or equal to the price not more than that.", "status"=>false],
        };
    }
}
