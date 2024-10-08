<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Location;
use App\Models\Parking;
use Illuminate\Http\Request;

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

    
}
