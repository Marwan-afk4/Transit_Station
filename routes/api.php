<?php

use App\Http\Controllers\Api\Admin\HomeController;
use App\Http\Controllers\Api\Admin\ParkingController;
use App\Http\Controllers\Api\Admin\PicklocationController;
use App\Http\Controllers\Api\Admin\UsersubsController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\CarController ;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/',[UserController::class,'index']);
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);


Route::middleware(['auth:sanctum','IsUser'])->group(function () {
    Route::get('/user/car',[CarController::class,'usercars']);

    Route::post('/user/car/add',[CarController::class,'addcar']);

    Route::get('/user/dropdown',[RequestController::class,'dropdown']);

    Route::post('/user/make-request',[RequestController::class,'addrequest']);

    Route::get('/user/subscription',[SubscriptionController::class,'subscription']);

    Route::get('/user/profile',[ProfileController::class,'profile']);

    Route::put('/user/profile/edit/{id}',[ProfileController::class,'editprofile']);

});


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {
    Route::get('/admin/home',[HomeController::class,'HomePage']);

    Route::get('/admin/locations',[PicklocationController::class,'showpickuplocation']);

    Route::post('/admin/locations/add',[PicklocationController::class,'addlocation']);

    Route::get('/admin/parking',[ParkingController::class,'showparking']);

    Route::post('/admin/parking/add',[ParkingController::class,'addparking']);

    Route::get('/admin/carparking/{id}',[ParkingController::class,'CarParking']);

    Route::delete('/admin/carparking/delete/{id}',[ParkingController::class,'deleteCar']);

    Route::get('/admin/subscription',[UsersubsController::class,'usersubscription']);

    Route::delete(('/admin/subscription/delete/{id}'),[UsersubsController::class,'destroy']);
});


Route::middleware(['auth:sanctum', 'IsDriver'])->group(function () {

});
