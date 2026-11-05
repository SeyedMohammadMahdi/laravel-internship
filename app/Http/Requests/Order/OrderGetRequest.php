<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderGetRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            "page" => "sometimes|integer|min:1",
            "limit" => "sometimes|integer|min:1",
        ];
    }

}
