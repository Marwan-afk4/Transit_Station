<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carcolor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    protected $carcolor=['color_name','color_code'];
    public function showcolors(){
        $colors=Carcolor::all();
        $data=[
            'colors'=>$colors
        ];
        return response()->json($data);
    }

    public function addColor(Request $request){
        $validate=Validator::make($request->all(),[
            'color_name'=>'required|string|unique:carcolors,color_name',
            'color_code'=>'nullable|string',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $color=Carcolor::create([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return response()->json(['message'=>'color added successfully','data'=>$color]);
    }

    public function updateColor(Request $request,$id){
        $validate=Validator::make($request->all(),$this->carcolor);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $color=Carcolor::find($id);
        $color->update([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return response()->json(['message'=>'color updated successfully','data'=>$color]);
    }

    public function deleteColor($id){
        $color=Carcolor::find($id);
        $color->delete();
        return response()->json(['message'=>'color deleted successfully']);
    }
}
