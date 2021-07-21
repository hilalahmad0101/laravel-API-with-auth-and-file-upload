<?php

use App\Http\Controllers\dummyapi;
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


Route::get("/getdata", [dummyapi::class, "index"]);

Route::post("/add", [dummyapi::class, "add"]);
Route::get("/edit/{id}", [dummyapi::class, "edit"]);
Route::put("/update/{id}", [dummyapi::class, "update"]);
Route::get("/search/{name}", [dummyapi::class, "search"]);
Route::delete("/delete/{id}", [dummyapi::class, "delete"]);