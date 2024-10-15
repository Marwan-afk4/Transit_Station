<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Driver;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomescreenController extends Controller
{

    protected $updatedatadriver=['name','email','phone','image'];

    public function showrequests(Request $request){
        $requests = ModelsRequest::with('driver' )
        ->where('driver_id', $request->user()->id)
        ->where('status','current')
        ->get();
        $data=[
            'requests'=>$requests->map(function($request){
                return [
                    'id'=>$request->id,
                    'car_id'=>$request->car_id ?? 'N/A',
                    'car_name' => $request->car->car_name ?? 'N/A',
                    'car_image' => $request->car->car_image ?? 'N/A',
                    'car_number' => $request->car->car_number ?? 'N/A',
                    'user_id'=>$request->user_id ?? 'N/A',
                    'user_name' => $request->user->name ?? 'N/A',
                    'user_phone' => $request->user->phone ?? 'N/A',
                    'user_image' => $request->user->image ?? 'N/A',
                    'location_id' => $request->location_id ?? 'N/A',
                    'location_name' => $request->location->pick_up_address ?? 'N/A',
                    'parking_id' => $request->location->parking_id ?? 'N/A',
                    'parking_name' => $request->location->parking->name ?? 'N/A',
                    'request_time' => $request->request_time,
                    'pick_up_date' => $request->pick_up_date,
                    'return_time' => $request->return_time,
                    'type' => $request->type,
                    'status' => $request->status,
                    'driver' => [
                        'id' => $request->driver->id,
                        'name' => $request->driver->name,
                        'email' => $request->driver->email,
                        'phone' => $request->driver->phone,
                    ],
                ];
            })
        ];
        return response()->json($data);
    }

    public function showprofile(Request $request){
        $profiledetails= $request->user();
        $data=[
            'profile'=>$profiledetails
        ];
        return response()->json($data);
    }

    public function updateprofile(Request $request){
        $driver=$request->user();
        $driver->update($request->only($this->updatedatadriver));
        $driver->save();
        $data=[
            'message'=>'profile updated successfully',
        ];
        return response()->json($data);
    }

    public function logout(Request $request){
        $user=$request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=>'logged out successfully']);
    }

    public function store(Request $request){
        $validate=Validator::make($request->all(),[
            'complaint'=>'required|string',

        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=Complaint::create([
            'complaint'=>$request->complaint,
            'driver_id'=>$request->user()->id,
            'date'=>now()
        ]);

        $data=[
            'message'=>'complaint added successfully',
            'data'=>$validate
        ];
        return response()->json($data);
    }

    public function onthewayupdate(Request $request) {
        $user=$request->user();
        $changetoOntheway = Driver::find($user->id)->first();
        $changetoOntheway->status = 'on the way';
        $changetoOntheway->save();

        return response()->json(['message' => 'Status updated to on the way']);
    }

    public function carrecivedupdate(Request $request) {
        $user = $request->user();

        $changetoCarrecived = Driver::where('id', $user->id)->first();
        if ($changetoCarrecived) {
            $changetoCarrecived->status = 'car received';
            $changetoCarrecived->save();

            return response()->json(['message' => 'Driver status updated to car received']);
        } else {
            return response()->json(['error' => 'Driver not found'], 404);
        }
    }

    public function arrivedupdate(Request $request) {
        $user = $request->user();

        $changetoArrived = Driver::where('id', $user->id)->first();

        if ($changetoArrived) {
            $changetoArrived->status = 'arrived';
            $changetoArrived->save();

            $changerequeststatus = ModelsRequest::find($request->request_id);
            if ($changerequeststatus) {
                $changerequeststatus->status = 'history';
                $changerequeststatus->save();

                return response()->json(['message' => 'Driver status updated to arrived and request status updated to history']);
            } else {
                return response()->json(['error' => 'Request not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Driver not found'], 404);
        }
    }
    }

