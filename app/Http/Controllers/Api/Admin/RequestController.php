<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Location;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    protected $updatestatus=['status'];
    public function requestHistory()
    {
        $data = ModelsRequest::
        with(['user.subscription.offer','location'])
        ->get();
        return response()->json($data);
    }

    public function makerequest(Request $request){
        $modelrequest= new ModelsRequest();
        $modelrequest->car_id=$request->car_id;
        $modelrequest->location_id=$request->location_id;
        $modelrequest->pick_up_date=$request->pick_up_date;
        $modelrequest->request_time=$request->request_time;
        $modelrequest->user_id=$request->user_id;
        $modelrequest->driver_id=$request->driver_id;
        $modelrequest->return_time=$request->return_time;
        $modelrequest->save();
        return response()->json(['message'=>'request made successfully']);
    }

    public function cancelrequest(Request $request){
        $modelrequest=ModelsRequest::find($request->request_id);
        $modelrequest->delete();
        return response()->json(['message'=>'request canceled successfully']);
    }

    public function getallids(){
        $users=User::all();
        $cars=Car::all();
        $locations=Location::all();
        $drivers=Driver::all();

        $data=[
            'users'=>$users,
            'cars'=>$cars,
            'locations'=>$locations,
            'drivers'=>$drivers
        ];
        return response()->json($data);
    }

    public function updatestatus(Request $request,$id){
        $modelrequest=ModelsRequest::find($id);
        $modelrequest->update($request->only($this->updatestatus));
        return response()->json(['message'=>'status updated successfully']);
    }

    public function postdriver(Request $request,$id){
        $modelrequest=ModelsRequest::find($id);
        $selectdriver=Driver::find($request->driver_id);
        $modelrequest->driver_id=$selectdriver->id;
        $modelrequest->save();
        return response()->json(['message'=>'done driver selected successfully']);
    }

    public function getdrivers(){
        $drivers=Driver::all();
        $data=[
            'drivers'=>$drivers
        ];
        return response()->json($data);
    }
}
