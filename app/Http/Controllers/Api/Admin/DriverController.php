<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Location;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator ;

class DriverController extends Controller
{
    protected $updatedriver=['phone','location_id','parking_id','cars_per_mounth','name','email'];
    public function showdrivers(){
        $drivers = Driver::with(['parking:id,name', 'parking.locations:id,address'])->get();
        $data = $drivers->map(function($driver) {
            return [
                'id' => $driver->id,
                'parking_id'=>$driver->parking->id,
                'name' => $driver->name,
                'email' => $driver->email,
                'phone' => $driver->phone,
                'image' => $driver->image,
                'salary' => $driver->salary,
                'cars_per_mounth' => $driver->cars_per_mounth,
                // 'location_address' => $driver->location->address ?? 'N/A', // Include location address
                'parking_name' => $driver->parking->name ?? 'N/A',         // Include parking name
            ];
        });
        $data2=[
            'drivers'=>$data
        ];

        return response()->json($data2);
    }

    public function editdriver(Request $request, $id){
        $driver=Driver::find($id);
        $driver->update($request->only($this->updatedriver));
        return response()->json(['message'=>'driver updated successfully']);
    }

    public function getdropdown(){
        $parkings=Parking::all();
        $locations=Location::all();
        $data=[
            'parkings'=>$parkings,
            'locations'=>$locations
        ];
        return response()->json($data);
    }

    public function deletedriver($id){
        $driver=Driver::find($id);
        $driver->delete();
        return response()->json(['message'=>'driver deleted successfully']);
    }

    public function adddriver(Request $request){
        $validate= Validator::make($request->all(),[
            'phone'=>'required|unique:drivers',
            'location_id'=>'nullable',
            'parking_id'=>'required',
            'cars_per_mounth'=>'required',
            'name'=>'required',
            'role'=>'nullable|in:driver',
            'password'=>'required|min:6',
            'image'=>'nullable',
            'salary'=>'required',
            'email'=>'required|email|unique:drivers',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }

        $validate=Driver::create([
            'phone'=>$request->phone,
            'location_id'=>$request->location_id ?? null,
            'parking_id'=>$request->parking_id,
            'cars_per_mounth'=>$request->cars_per_mounth,
            'name'=>$request->name,
            'role'=>$request->role ,
            'salary'=>$request->salary,
            'password'=>Hash::make($request->password),
            'email'=>$request->email,
            'image'=>$request->image ?? ''
        ]);
        $data=[
            'message'=>'added successfully',
            'data'=>$validate
        ];
        return response()->json($data);
    }

    public function getdriverlocations($id){
        $driver=Driver::with('parking.locations')->find($id);
        if(!$driver){
            return response()->json(['message'=>'driver not found'],404);
        }
        // $locations = $driver->availableLocations();
        return response()->json(['drivers'=>$driver]);
    }

    public function getParkingDetails($parking_id)
{
    $parking = Parking::with(['drivers', 'locations'])->find($parking_id);

    if (!$parking) {
        return response()->json(['message' => 'Parking not found'], 404);
    }

    return response()->json([
        'parking_name' => $parking->name,
        'drivers' => $parking->drivers->map(function($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'email' => $driver->email,
                'phone' => $driver->phone
            ];
        }),
        'locations' => $parking->locations->map(function($location) {
            return [
                'id' => $location->id,
                'address' => $location->address,
                'pick_up_address' => $location->pick_up_address
            ];
        })
    ]);
}

}
