<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "name"=>"sometimes|string",
            "category"=>"sometimes|string",
            "is_available"=>"sometimes|boolean",
            "min_price"=>"sometimes|numeric",
            "max_price"=>"sometimes|numeric",
        ];
    }

}
