<?php

namespace App\Http\Requests\Product;

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
                "name"=> "required|string|between:3,255",
                "price"=> "required|numeric|between:0,1000",
                "stock"=> "required|integer|min:0",
                "category"=> "required|string|between:3,100",
        ];
    }

    public function messages()
    {
        return [
           "name.required"=> "enter the product name it is required",
           "name.string"=> "the product name must be string",
           "name.between"=> "the length of product name must be between :min and :max characters",
           "price.required" => "enter the product price it is required",
           "price.numeric" => "the product price must be a number",
           "price.between" => "the product price must be between :min and :max",
           "stock.required" => "enter the product stock it is required",
           "stock.integer" => "the product stock must be a number",
           "stock.min" => "the product stock must be at least :min",
           "category.required" => "enter the product category it is required",
           "category.string" => "the product category must be string",
           "category.between" => "the product category must be between :min and :max characters",
        ];
    }
}
