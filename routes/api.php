<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Middleware\NationalCodeValidation;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/*
 *
 * one way of handling request without controller
 */
Route::get('/hello', function (Request $request) {
    $name = $request->query('name');
    if ($name) {
        return response()->json(["message" => "hello $name"]);
    }
    return response()->json(["message" => "Hello World!"], 200);
});

/*
 * handling requests with controller
 */
Route::get('/helloV2', [Controllers\HelloController::class, 'hello_world']);

Route::get('/helloV3/{name}', [Controllers\HelloController::class, 'hello_with_param']);

Route::post('/userData', [Controllers\UserController::class, 'get_user_data'])->middleware(NationalCodeValidation::class);
//Route::post('/input2/',[Controllers\HelloController::class, 'input2']);
//Route::post('/input3/',[Controllers\HelloController::class, 'input3']);
Route::get('/version', [Controllers\HelloController::class, 'version']);


Route::get('/userList', [Controllers\UserController::class, 'userList']);


######################################
#   product handling APIs
######################################

Route::get('getProducts/{id?}', [Controllers\ProductController::class, 'getProducts']);
Route::get('filterProducts', [Controllers\ProductController::class, 'filterProducts']);
Route::post("/products/create", [Controllers\Product\ProductController::class, 'createProduct']);
Route::get("/products/get/{id?}", [Controllers\Product\ProductController::class, 'getProducts']);
Route::delete("/products/delete/{id}", [Controllers\Product\ProductController::class, 'deleteProduct']);
Route::put("/products/update", [Controllers\Product\ProductController::class, 'updateProduct']);
Route::post("/products/filter", [Controllers\Product\ProductController::class, 'filterProducts']);

#####################################
#   order API
#####################################
Route::post("/order/create", [Controllers\Order\OrderController::class, 'create']);
Route::get("/order/get", [Controllers\Order\OrderController::class, 'getAll']);
Route::patch("/order/cancel", [Controllers\Order\OrderController::class, 'cancelOrder']);
#####################################
#   Notification API
#####################################

Route::post('sendNotification', [Controllers\NotificationController::class, 'sendNotification']);


####################################
#   discount API
####################################

Route::post('/calculatePrice', [Controllers\ProductController::class, 'calculateDiscount']);

####################################
#   User API
####################################

Route::post('/user', [Controllers\User\UserController::class, 'createUser']);
Route::put("/user", [Controllers\User\UserController::class, 'updateUser']);
Route::get("/user", [Controllers\User\UserController::class, 'getUser']);
Route::delete("/user", [Controllers\User\UserController::class, 'deleteUser']);


######################################
#   product Image
######################################
Route::post("/product/image", [Controllers\Product\ProductController::class, 'uploadProductImage']);
Route::delete("/product/deleteImage/{productId}", [Controllers\Product\ProductController::class, 'deleteProductImage']);
