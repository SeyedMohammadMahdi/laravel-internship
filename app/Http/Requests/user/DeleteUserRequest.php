<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public int $id;
    public function rules(): array {
        return [
            "id" => "required|exists:users,id"
        ];
    }

    public function messages(): array {
        return [
            "id.required" => "user id is required.",
            "id.exists" => "user id not found.",
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function passedValidation()
    {
        $this->id = $this->validated()["id"];
    }
}
