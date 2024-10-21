<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Carcolor;
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
            'car_image'=>'nullable',
            'carcolor_id'=>'required|exists:carcolors,id'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }

        $validate=Car::create([
            'car_number'=>$request->car_number,
            'car_name'=>$request->car_name,
            'car_image'=>$request->car_image ?? 'defualt.png',
            'carcolor_id'=>$request->carcolor_id,
            'user_id'=>$request->user()->id
        ]);
        $data=[
            'id'=>$validate->id,
            'car_number'=>$request->car_number,
            'car_name'=>$request->car_name,
            'car_image'=>$request->car_image ?? null,
            'user_id'=>$request->user()->id,
            'carcolor_id'=>$request->carcolor_id,
            'color_name'=>$validate->carcolor->color_name,
            'color_code'=>$validate->carcolor->color_code,
        ];
        return response()->json(['message'=>'car added successfully','data'=>$data]);
    }

    public function allcolors(){
        $colors=Carcolor::all();
        $data=[
            'colors'=>$colors
        ];
        return response()->json($data);
    }
}
