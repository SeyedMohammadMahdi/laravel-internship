<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model
{
    protected $table = 'order__items';
    protected $fillable = ["order_id", "product_id", "quantity"];
}
