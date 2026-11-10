<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\DeleteUserRequest;
use App\Http\Requests\user\GetUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Http\Requests\user\UserCreateRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct() {
        $this->userService = app(UserService::class);
    }
    public function createUser(UserCreateRequest $request): JsonResponse{
        $data = $request->user;
        $resp = $this->userService->create($data);
//        $resp = $this->userService->create($data["name"], $data["email"], $data["password"]);
        return response()->json($resp, $resp["status_code"]);
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse {
        $user = $request->user;
//        $resp = $this->userService->update($data["id"], $data["name"], $data["email"], $data["password"]);
        $resp = $this->userService->update($user);
        return response()->json($resp, $resp["status_code"]);
    }

    public function getUser(GetUserRequest $request): JsonResponse {
        $user = $request->user;
        $resp = $this->userService->get($user->id);
        return response()->json($resp, $resp["status_code"]);
    }

    public function deleteUser(DeleteUserRequest $request): JsonResponse {
        $id = $request->id;
        $resp = $this->userService->delete($id);
        return response()->json($resp, $resp["status_code"]);
    }

}
