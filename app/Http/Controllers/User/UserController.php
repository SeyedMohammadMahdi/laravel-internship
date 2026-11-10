<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct() {
        $this->userService = app(UserService::class);
    }
    public function createUser(Request $request): JsonResponse{
        $data = $request->json()->all();
        $resp = $this->userService->create(...$data);
//        $resp = $this->userService->create($data["name"], $data["email"], $data["password"]);
        return response()->json($resp, $resp["status_code"]);
    }

    public function updateUser(Request $request): JsonResponse {
        $data = $request->json()->all();
//        $resp = $this->userService->update($data["id"], $data["name"], $data["email"], $data["password"]);
        $resp = $this->userService->update(...$data);
        return response()->json($resp, $resp["status_code"]);
    }

}
