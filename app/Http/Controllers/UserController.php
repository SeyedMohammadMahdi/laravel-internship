<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserList;
class UserController extends Controller
{
    public function userList(UserList $userList): JsonResponse{
        return response()->json($userList->ListUsers(), 200);
    }
}
