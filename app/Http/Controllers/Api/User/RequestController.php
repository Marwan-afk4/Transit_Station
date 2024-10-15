<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
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

        $user=$request->user();
        $currentdate=Carbon::now();
        $subscription=$user->subscription()->latest()->first();
        if(!$subscription || ($subscription->end_date &&$currentdate->greaterThan($subscription->end_date))){
            return response()->json(['message'=>'Please subscribe first'],403);
        }

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
        $validate=new ModelsRequest();
        $validate->car_id=$request->car_id;
        $validate->location_id=$request->location_id;
        $validate->pick_up_date=$request->pick_up_date;
        $validate->request_time=$request->request_time;
        $validate->return_time=$request->return_time;
        if($request->return_time==null){
            $validate->type='return_req';
        }
        else{
            $validate->type='new_req';
        }
        $validate->user_id=$request->user()->id;
        $validate->save();
        
        $data=[
            'message'=>'Request done',
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
