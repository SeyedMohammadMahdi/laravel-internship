<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductDeleteRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            "id" => "required|integer"
        ];
    }

    public function prepareForValidation()
    {
        if($this->route("id")){
            $this->merge([
                "id" => $this->route("id")
            ]);
        }
    }
}
