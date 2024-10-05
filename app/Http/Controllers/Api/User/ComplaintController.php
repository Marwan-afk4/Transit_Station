<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    public function store(Request $request){
        $validate=Validator::make($request->all(),[
            'complaint'=>'required|string',

        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $validate=Complaint::create([
            'complaint'=>$request->complaint,
            'user_id'=>$request->user()->id,
            'date'=>now()
        ]);

        $data=[
            'message'=>'complaint added successfully',
            'data'=>$validate
        ];
        return response()->json($data);
    }
}
