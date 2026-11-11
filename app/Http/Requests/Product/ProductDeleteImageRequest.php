<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductDeleteImageRequest extends FormRequest
{

    public int $productId;

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'productId' => 'required|integer|exists:products,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'productId' => $this->route('productId'),
        ]);
    }

    public function passedValidation()
    {
        $this->productId = $this->validated()['productId'];
    }

}
