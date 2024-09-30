<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PicklocationController extends Controller
{
    public function showpickuplocation(Request $request){
        $locationdata=Location::all();
        $data=[
            'locations'=>$locationdata
        ];
        return response()->json($data);
    }

    public function addlocation(Request $request){
        $validate=Validator::make($request->all(),[
            'address'=>'nullable',
            'address_in_detail'=>'required',
            'pick_up_address'=>'required',
            'location_image'=>'nullable',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=Location::create([
            'address'=>$request->address,
            'address_in_detail'=>$request->address_in_detail,
            'pick_up_address'=>$request->pick_up_address,
            'location_image'=>$request->location_image ??'default.png'
        ]);

        $data=[
            'message'=>'location added successfully',
            'data'=>$validate
        ];
        return response()->json($data);

    }
}
