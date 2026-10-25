<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
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

Route::get('/hello2', [HelloController::class, 'hello']);

Route::get('/hello3/{name}', [HelloController::class, 'hello_with_param']);

Route::post('/input', [HelloController::class, 'input']);
Route::post('/input2/',[HelloController::class, 'input2']);
Route::post('/input3/',[HelloController::class, 'input3']);
