<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required|unique:users',
            'role'=>'nullable|in:admin,user,driver',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),400);
    }

    $validate=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'phone'=>$request->phone,
        'role'=>$request->role ?? 'user',
    ]);
    $token = $validate->createToken('*')->plainTextToken;
    $data=[
        'message'=>'registered successfully',
        'data'=>$validate,
        'token'=>$token,
    ];
    return response()->json($data);
}


    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'invalid credentials'],401);
        }
        $role=Auth::user()->role;
        $user= Auth::user();
        $token=$user->createToken('auth_token')->plainTextToken;
        $data=[
            'message'=>'logged in successfully',
            'data'=>$user,
            'token'=>$token,
            'role'=>$role
        ];
        return response()->json($data);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
