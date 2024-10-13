<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;

use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{

    protected $updaterequest=['pick_up_date','request_time','return_time','car_id','location_id'];
    public function dropdown(Request $request){
        $user=$request->user();
        $car=$user->cars;
        $locations=Location::all();
        $data=[
            'cars'=>$car,
            'locations'=>$locations,
        ];
        return response()->json($data);
    }


    public function addrequest(Request $request){
        $validate=Validator::make($request->all(),[
            'car_id'=>'required|exists:cars,id',
            'location_id'=>'required|exists:locations,id',
            'pick_up_date'=>'required',
            'request_time'=>'required',
            'return_time'=>'nullable|date',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=ModelsRequest::create([
            'car_id'=>$request->car_id,
            'location_id'=>$request->location_id,
            'pick_up_date'=>$request->pick_up_date,
            'request_time'=>$request->request_time,
            'return_time'=>$request->return_time,
            'user_id'=>$request->user()->id
        ]);
        $data=[
            'message'=>'Request done',
            'data'=>$validate,
        ];

        return response()->json($data);
    }

    public function getrequests(Request $request){
        $user=$request->user();
        $requests=$user->request;
        $data=[
            'requests'=>$requests
        ];
        return response()->json($data);
    }

    public function cancelrequest(Request $request,$id){
        $modelrequest=ModelsRequest::find($id);
        $modelrequest->delete();
        return response()->json(['message'=>'request canceled successfully']);
    }

    public function updaterequest(Request $request,$id){
        $modelrequest=ModelsRequest::find($id);
        $modelrequest->update($request->only($this->updaterequest));
        return response()->json(['message'=>'request updated successfully']);
    }
}
