<?php

namespace App\Http\Requests\user;

use App\DTOs\UserDataDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public UserDataDTO $user;

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $this->user = new UserDataDTO(...$data);
    }
}
