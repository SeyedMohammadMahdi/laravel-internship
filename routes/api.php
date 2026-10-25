<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Middleware\NationalCodeValidation;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', function (Request $request) {
    $name = $request->query('name');
    if ($name) {
        return response()->json(["message" => "hello $name"]);
    }
    return response()->json(["message" => "Hello World!"], 200);
});

Route::get('/hello2', [Controllers\HelloController::class, 'hello']);

Route::get('/hello3/{name}', [Controllers\HelloController::class, 'hello_with_param']);

Route::post('/input', [Controllers\HelloController::class, 'input']);
Route::post('/input2/',[Controllers\HelloController::class, 'input2']);
Route::post('/input3/',[Controllers\HelloController::class, 'input3'])->middleware(NationalCodeValidation::class);

Route::get('/userList', [Controllers\UserController::class, 'userList']);
