<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                "name"=> "required|string|between:10,255",
                "price"=> "required|numeric|between:0,1000",
                "stock"=> "required|integer|min:0",
                "category"=> "required|string|between:10,100",
        ];
    }
}
