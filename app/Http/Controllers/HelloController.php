<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\InputValidation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\error;
use App\Services\UserList;

class HelloController extends Controller
{
    public function hello_world(): JsonResponse{
        return response()->json(["message" => "Hello World! this is from controller"], 200);
    }

    public function hello_with_param(string $name): JsonResponse{
        return response()->json(["message" => "Hello $name! this is from controller"], 200);
    }

    public function version(): JsonResponse{
        $version = config('app.version');
        return response()->json(["version" => $version], 200);
    }
}
