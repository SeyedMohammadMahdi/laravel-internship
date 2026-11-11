<?php

namespace App\Http\Requests\Order;

use App\DTOs\Order\OrderCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{

    public OrderCreateDTO $orderDTO;
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "customer_name" => "required|string",
            "items" => "required|array",
            "items.*.id" => "required|integer|exists:products,id",
            "items.*.amount" => "required|integer|min:1",
        ];
    }

    public function messages(): array {
        return [
            "customer_name.required" => "Customer name is required.",
            "items.required" => "Items is required.",
            "items.*.id.required" => "Item id is required.",
            "items.*.id.integer" => "Item id must be an integer.",
            "items.*.amount.required" => "Item amount is required.",
            "items.*.amount.integer" => "Item amount must be an integer.",
            "items.*.amount.min" => "Item amount must be at least 1.",
            "items.*.id.exists" => "Item :position id does not exist.",
        ];
    }

    protected function passedValidation(): void {
        $data = $this->validated();
        $this->orderDTO = new OrderCreateDTO($data["customer_name"], $data["items"]);
    }

}
