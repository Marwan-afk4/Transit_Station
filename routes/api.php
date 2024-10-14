<?php

use App\Http\Controllers\Api\Admin\AlluserController;
use App\Http\Controllers\Api\Admin\DriverController;
use App\Http\Controllers\Api\Admin\ExpenceController;
use App\Http\Controllers\Api\Admin\HomeController;
use App\Http\Controllers\Api\Admin\ParkingController;
use App\Http\Controllers\Api\Admin\PicklocationController;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\RequestController as AdminRequestController;
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

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);


Route::middleware(['auth:sanctum','IsUser'])->group(function () {
    Route::get('/user/car',[CarController::class,'usercars']);

    Route::post('/user/car/add',[CarController::class,'addcar']);

    Route::get('/user/dropdown',[RequestController::class,'dropdown']);

    Route::post('/user/make-request',[RequestController::class,'addrequest']);

    Route::get('/user/requests',[RequestController::class,'getrequests']);

    Route::delete('/user/requests/delete/{id}',[RequestController::class,'cancelrequest']);

    Route::put('/user/requests/update/{id}',[RequestController::class,'updaterequest']);

    Route::get('/user/subscription-details',[SubscriptionController::class,'subscription']);

    Route::get('/user/profile',[ProfileController::class,'profile']);

    Route::put('/user/profile/edit',[ProfileController::class,'editprofile']);

    Route::post('/user/complaint',[ComplaintController::class,'store']);

    Route::post('/user/logout',[UserController::class,'logout']);

});


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {
    Route::get('/admin/home',[HomeController::class,'HomePage']);

    Route::get('/admin/profile',[AlluserController::class,'adminprofile']);

    Route::put('/admin/profile/edit',[AlluserController::class,'edirptofileadmin']);

    Route::post('/admin/logout',[HomeController::class,'logout']);
////////////////////////////////////////// location routes //////////////////////////////////////////
    Route::get('/admin/locations',[PicklocationController::class,'showpickuplocation']);

    Route::post('/admin/locations/add',[PicklocationController::class,'addlocation']);

    Route::put('/admin/locations/update/{id}',[PicklocationController::class,'updatelocation']);

    Route::delete('/admin/locations/delete/{id}',[PicklocationController::class,'deletelocation']);
////////////////////////////////////////// parking routes //////////////////////////////////////////
    Route::get('/admin/parking',[ParkingController::class,'showparking']);

    Route::post('/admin/parking/add',[ParkingController::class,'addparking']);

    Route::put('/admin/parking/update/{id}',[ParkingController::class,'update']);

    Route::get('/admin/carparking/{id}',[ParkingController::class,'CarParking']);

    Route::delete('/admin/carparking/delete/{id}',[ParkingController::class,'deleteCar']);

    Route::delete('/admin/parking/delete/{id}',[ParkingController::class,'destroy']);

////////////////////////////////////////// subscription routes //////////////////////////////////////////
    Route::get('/admin/subscription',[UsersubsController::class,'usersubscription']);

    Route::delete(('/admin/subscription/delete/{id}'),[UsersubsController::class,'destroy']);

    Route::get('/admin/offer/dropdown',[UsersubsController::class,'offers']);

    Route::post('/admin/subscription/add',[UsersubsController::class,'addsubscription']);

    Route::put(('/admin/subscription/update/{user_id}'),[UsersubsController::class,'update']);
////////////////////////////////////////// revenue routes //////////////////////////////////////////
    Route::get('/admin/revenue',[RevenueController::class,'showrevenue']);

    Route::put('/admin/revenue/update/{id}',[RevenueController::class,'update']);

    Route::get('/admin/revenue/types',[RevenueController::class,'revenuetypes']);

    Route::post('/admin/revenue/add',[RevenueController::class,'addrevenue']);

    Route::post('/admin/revenue/addtype',[RevenueController::class,'addrevenueType']);

    Route::delete('/admin/revenue/types/delete/{id}',[RevenueController::class,'deleterevenueType']);

    Route::put('/admin/revenue/types/update/{id}',[RevenueController::class,'updaterevenueType']);

    Route::delete('/admin/revenue/destroy/{id}',[RevenueController::class,'destroy']);
////////////////////////////////////////// expence routes //////////////////////////////////////////
    Route::get('/admin/expence',[ExpenceController::class,'showexcpence']);

    Route::put('/admin/expence/update/{id}',[ExpenceController::class,'update']);

    Route::post('/admin/expence/add',[ExpenceController::class,'addexpence']);

    Route::get('/admin/expence/types',[ExpenceController::class,'expencetypes']);

    Route::post('/admin/expence/addtype',[ExpenceController::class,'addexpencetype']);

    Route::delete('/admin/expence/types/delete/{id}',[ExpenceController::class,'deleterevenueType']);

    Route::put('/admin/expence/types/update/{id}',[ExpenceController::class,'updaterevenueType']);

    Route::delete('/admin/expence/destroy/{id}',[ExpenceController::class,'destroy']);
////////////////////////////////////////// plans routes //////////////////////////////////////////
    Route::get('/admin/plan',[PlanController::class,'showplans']);

    Route::post('/admin/plan/add',[PlanController::class,'addplan']);

    Route::put('/admin/plan/update/{id}',[PlanController::class,'update']);

    Route::delete('/admin/plan/delete/{id}',[PlanController::class,'destroy']);
////////////////////////////////////////// request routes //////////////////////////////////////////
    Route::get('/admin/request',[AdminRequestController::class,'requestHistory']);

    Route::post('/admin/request/make',[AdminRequestController::class,'makerequest']);

    Route::delete('/admin/request/delete/{id}',[AdminRequestController::class,'cancelrequest']);

    Route::get('/admin/request/dropdown',[AdminRequestController::class,'getallids']);

    Route::put('/admin/request/update/{id}',[AdminRequestController::class,'updatestatus']);

    Route::post('/admin/request/selectdriver/{id}',[AdminRequestController::class,'postdriver']);

    Route::get('/admin/request/drivers',[AdminRequestController::class,'getdrivers']);

////////////////////////////////////////// usersScreen routes //////////////////////////////////////////
    Route::get('/admin/users',[AlluserController::class,'usersubscription']);

    Route::post('/admin/users/add',[AlluserController::class,'adduser']);

    Route::put('/admin/users/update/{id}',[AlluserController::class,'updateuser']);

    Route::delete('/admin/users/delete/{id}',[AlluserController::class,'deleteuser']);
////////////////////////////////////////// driver routes //////////////////////////////
    Route::get('/admin/drivers',[DriverController::class,'showdrivers']);

    Route::put('/admin/drivers/update/{id}',[DriverController::class,'editdriver']);

    Route::post('/admin/drivers/add',[DriverController::class,'adddriver']);

    Route::get('/admin/drivers/dropdown',[DriverController::class,'getdropdown']);

    Route::delete('/admin/drivers/delete/{id}',[DriverController::class,'deletedriver']);

    Route::get('/admin/drivers/{id}/locations',[DriverController::class,'getdriverlocations']);

    Route::get('/admin/parkingdrivers',[DriverController::class,'getparkingdriver']);

});


Route::middleware(['auth:sanctum', 'IsDriver'])->group(function () {

});
