<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json(['success' => $user]);
    }

    public function editprofile(Request $request, $id)
{
    $validate=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'requird|email|unique:users,email,',
        'phone'=>'required|unique:users,phone,',
        'image'=>'nullable|string',
    ]);

    if($validate->fails()){
        return response()->json($validate->errors(),400);
    }
    $user=User::find($id);
    $user->name=$request->name;
    $user->email=$request->email;
    $user->phone=$request->phone;
    $user->image=$request->image;
    $user->save();
    $data=[
        'message'=>'updated successfully',
        'data'=>$user,
    ];
    return response()->json($data);
}
    }


