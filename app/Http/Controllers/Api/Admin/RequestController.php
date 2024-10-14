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
    $requests = ModelsRequest::with(['user.subscription.offer', 'location', 'car'])->get();
    $data = $requests->map(function($request) {
        $subscription = $request->user->subscription->first(); // Get the first subscription

        return [
            'id' => $request->id,
            'car_name' => $request->car->car_name ?? 'N/A',
            'user_name' => $request->user->name ?? 'N/A',
            'user_id'=>$request->user->id,
            'location_name' => $request->location->address ?? 'N/A',
            'request_time' => $request->request_time,
            'pick_up_date' => $request->pick_up_date,
            'return_time' => $request->return_time,
            'status' => $request->status,
            'offer_id' => $subscription->offer->id ?? null,
            'offer_name' => $subscription->offer->offer_name ?? 'N/A',
        ];
    });

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

    public function cancelrequest($id){
        $modelrequest=ModelsRequest::find($id);
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
        if(!$modelrequest){
            return response()->json(['message'=>'request not found']);
        }
        $selectdriver=Driver::find($request->driver_id);
        if(!$selectdriver){
            return response()->json(['message'=>'driver not found']);
        }
        $modelrequest->driver_id = $selectdriver->id;
        $modelrequest->status="current";
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
