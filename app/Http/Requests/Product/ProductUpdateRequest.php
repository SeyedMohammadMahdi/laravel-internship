<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    public function rules(){
        return [
            "id" => "required|integer|min:1",
            "data"=> "required|array",
            "data.name"=> "sometimes|string|min:3",
            "data.category"=> "sometimes|string|min:3",
            "data.price"=> "sometimes|numeric:|min:0",
            "data.stock"=> "sometimes|integer|min:0",
        ];
    }

}
