<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['product_id', "status", "customer_name", "total_amount"];
    protected $table = "orders";
    protected $primaryKey = "id";
}
