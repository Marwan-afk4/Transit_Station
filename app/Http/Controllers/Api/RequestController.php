<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Location;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function dropdown(Request $request){
        $user=$request->user();
        $car=$user->cars;
        $locations=Location::all();
        $data=[
            'cars'=>$car,
            'locations'=>$locations
        ];
        return response()->json($data);
    }







    public function addrequest(Request $request){
        $validate=Validator::make($request->all(),[
            'car_name'=>'required',
            'pickup_location'=>'required',
            'pickup_date'=>'required',
            'pick_up_time'=>'required',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=ModelsRequest::create([
            'car_name'=>$request->car_name,
            'pickup_location'=>$request->pickup_location,
            'pickup_date'=>$request->pickup_date,
            'pick_up_time'=>$request->pick_up_time,
            'user_id'=>$request->user()->id
        ]);
        $data=[
            'message'=>'Request done',
            'data'=>$validate,
        ];
    }
}
