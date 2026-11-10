<?php

namespace App\Http\Requests\user;

use App\DTOs\UserDataDTO;
use Illuminate\Foundation\Http\FormRequest;

class GetUserRequest extends FormRequest
{
    public UserDataDTO $user;
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "id" => "sometimes|exists:users,id",
        ];
    }

    public function passedValidation()
    {
        $data = $this->validated();
        $this->user = new UserDataDTO(...$data);
    }


    public function messages(): array {
        return [
          "id.exists" => "the user does not exists",
        ];
    }
}
