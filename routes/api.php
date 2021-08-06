<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dummyapi;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// register Routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

// public routes
Route::get("/search/{name}", [dummyapi::class, "search"]);


Route::post("/product",[ProductController::class,"create"]);
Route::get("/getProduct",[ProductController::class,"getProduct"]);
Route::get("/editProduct/{id}",[ProductController::class,"editProduct"]);
Route::post("/updateProduct/{id}",[ProductController::class,"updateProduct"]);
Route::get("/deleteProduct/{id}",[ProductController::class,"deleteProduct"]);
// protected routes
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get("/getdata", [dummyapi::class, "index"]);
    Route::post("/add", [dummyapi::class, "add"]);
    Route::get("/edit/{id}", [dummyapi::class, "edit"]);
    Route::put("/update/{id}", [dummyapi::class, "update"]);
    Route::delete("/delete/{id}", [dummyapi::class, "delete"]);
    Route::post("/logout", [AuthController::class, "logout"]);
});
