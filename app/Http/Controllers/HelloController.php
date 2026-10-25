<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\InputValidation;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\error;
use App\Services\UserList;

class HelloController extends Controller
{
    public function hello(): JsonResponse{
        return response()->json(["message" => "Hello World! this is from controller"], 200);
    }

    public function hello_with_param(string $name): JsonResponse{
        return response()->json(["message" => "Hello $name! this is from controller"], 200);
    }

    public function input(InputValidation $request): JsonResponse{
        $body = $request->validated();
        return response()->json($body, 200);
    }

    public function input2(Request $request): JsonResponse{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:5,50',
            'age' => 'required|integer|between:18,50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        return response()->json($validator->validated(), 200);
    }

    public function input3(Request $request): JsonResponse{
        $validator = $request->validate(
            [
                'name' => 'required|string|between:5,50',
                'age' => 'required|integer|between:18,50',
            ]
        );

        return response()->json($validator, 200);
    }
}
