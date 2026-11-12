<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCancelRequest extends FormRequest
{
    public int $id;

    public function rules(): array {
        return [
            'id' => ['required', 'integer', 'exists:orders,id'],
        ];
    }
    public function authorize(): bool {
        return true;
    }

    public function passedValidation(): void {
        $this->id = $this->validated()["id"];
    }
}
