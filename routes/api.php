<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/',[UserController::class,'index']);
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/car',[CarController::class,'usercars']);
    Route::post('/user/car/add',[CarController::class,'addcar']);
});
