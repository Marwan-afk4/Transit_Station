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
        $drivers= Driver::all();
        $data=[
            'drivers'=>$drivers
        ];
        return response()->json($data);
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
            'location_id'=>'required',
            'parking_id'=>'required',
            'cars_per_mounth'=>'required',
            'name'=>'required',
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
            'location_id'=>$request->location_id,
            'parking_id'=>$request->parking_id,
            'cars_per_mounth'=>$request->cars_per_mounth,
            'name'=>$request->name,
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
}
