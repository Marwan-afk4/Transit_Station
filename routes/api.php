<?php

use App\Http\Controllers\Api\Admin\HomeController;
use App\Http\Controllers\Api\Admin\ParkingController;
use App\Http\Controllers\Api\Admin\PicklocationController;
use App\Http\Controllers\Api\Admin\RevenueController;
use App\Http\Controllers\Api\Admin\UsersubsController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\User\CarController;
use App\Http\Controllers\Api\User\ComplaintController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\RequestController;
use App\Http\Controllers\Api\User\SubscriptionController;
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

    Route::get('/user/subscription-details',[SubscriptionController::class,'subscription']);

    Route::get('/user/profile',[ProfileController::class,'profile']);

    Route::put('/user/profile/edit',[ProfileController::class,'editprofile']);

    Route::post('/user/complaint',[ComplaintController::class,'store']);

    Route::post('/user/logout',[UserController::class,'logout']);

});


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {
    Route::get('/admin/home',[HomeController::class,'HomePage']);

    Route::post('/admin/logout',[HomeController::class,'logout']);
//                         location routes
    Route::get('/admin/locations',[PicklocationController::class,'showpickuplocation']);

    Route::post('/admin/locations/add',[PicklocationController::class,'addlocation']);

    Route::put('/admin/locations/update/{id}',[PicklocationController::class,'updatelocation']);

    Route::delete('/admin/locations/delete/{id}',[PicklocationController::class,'deletelocation']);
//                         parking routes
    Route::get('/admin/parking',[ParkingController::class,'showparking']);

    Route::post('/admin/parking/add',[ParkingController::class,'addparking']);

    Route::put('/admin/parking/update/{id}',[ParkingController::class,'update']);

    Route::get('/admin/carparking/{id}',[ParkingController::class,'CarParking']);

    Route::delete('/admin/carparking/delete/{id}',[ParkingController::class,'deleteCar']);
//                         subscription routes
    Route::get('/admin/subscription',[UsersubsController::class,'usersubscription']);

    Route::delete(('/admin/subscription/delete/{id}'),[UsersubsController::class,'destroy']);

    Route::get('/admin/offer/dropdown',[UsersubsController::class,'offers']);

    Route::put(('/admin/subscription/update/{user_id}'),[UsersubsController::class,'update']);
//                         revenue routes
    Route::get('/admin/revenue',[RevenueController::class,'showrevenue']);

    Route::put('/admin/revenue/update/{id}',[RevenueController::class,'update']);

    Route::get('/admin/revenue/types',[RevenueController::class,'revenuetypes']);

    Route::post('/admin/revenue/add',[RevenueController::class,'addrevenue']);

    Route::delete('/admin/revenue/destroy/{id}',[RevenueController::class,'destroy']);

});


Route::middleware(['auth:sanctum', 'IsDriver'])->group(function () {

});
