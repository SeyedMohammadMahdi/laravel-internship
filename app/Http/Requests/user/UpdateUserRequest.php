<?php

namespace App\Http\Requests\user;

use App\DTOs\UserDataDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public UserDataDTO $user;
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            "id" => "required|exists:users,id",
            "name"=>"sometimes|required|string",
            "email"=>"sometimes|required|email|unique:users,email",
            "password"=>"sometimes|required|string",
        ];
    }

    public function passedValidation()
    {
        $data =  $this->validated();
        $this->user = new UserDataDTO(
            $data['id'],
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null,
        );
    }

}
