<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

    public function usercars(Request $request ){
        $user=$request->user();
        return response()->json(['success' =>$user->cars]);
    }

    public function addcar(Request $request){
        $validate=Validator::make($request->all(),[
            'car_number'=>'required|unique:cars',
            'car_name'=>'required',
            'car_image'=>'nullable|image',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=Car::create([
            'car_number'=>$request->car_number,
            'car_name'=>$request->car_name,
            'car_image'=>$request->car_image ?? 'defualt.png',
            'user_id'=>$request->user()->id
        ]);
        $data=[
            'message'=>'added successfully',
            'data'=>$validate,
        ];
        return response()->json($data);
    }

}
