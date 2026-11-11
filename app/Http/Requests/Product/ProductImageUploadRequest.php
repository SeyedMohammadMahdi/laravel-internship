<?php

namespace App\Http\Requests\Product;

use App\DTOs\Product\ProductImageUploadDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProductImageUploadRequest extends FormRequest
{
    public ProductImageUploadDTO $imageUploadDTO;
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'file' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            "product_id" => "required|exists:products,id",
        ];
    }

    public function passedValidation()
    {
        $data = $this->validated();
        $this->imageUploadDTO = new ProductImageUploadDTO(
            $data["product_id"],
            $data["file"]
        );
    }

}
