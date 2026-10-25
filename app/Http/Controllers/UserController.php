<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userList(UserList $userList): JsonResponse{
        return response()->json($userList->ListUsers(), 200);
    }

    public function get_user_data(InputValidation $request): JsonResponse{
        $ip = $request->ip();
        Log::info("Controller: received the user request. ip: $ip");
        $body = $request->validated();
        return response()->json($body, 200);
    }

//    other formats of validating the data
//    public function get_user_data(Request $request): JsonResponse{
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|string|between:5,50',
//            'age' => 'required|integer|between:18,50',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 400);
//        }
//        return response()->json($validator->validated(), 200);
//    }

//    public function get_user_data(Request $request): JsonResponse{
//        $ip = $request->ip();
//        Log::info("Controller: received the user request. ip: $ip");
//        $validator = $request->validate(
//            [
//                'name' => 'required|string|between:5,50',
//                'age' => 'required|integer|between:18,50',
//            ]
//        );
//        return response()->json($validator, 200);
//    }
}
