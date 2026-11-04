<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductGetRequest extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'id'=>"sometimes|integer|min:1",
            "page"=>"sometimes|integer|min:1",
            "perPage"=>"sometimes|integer|min:1",
        ];
    }

    public function prepareForValidation()
    {

        if($this->route("id")){
            $this->merge([
                "id"=>$this->route("id")
            ]);
        }
    }
}
