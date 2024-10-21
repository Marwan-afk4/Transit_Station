<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminPosition;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function generateNextCode(){
        $lastCode = User::max('user_code');

        if (!$lastCode) {
            // If no code exists yet, start with 'A001'
            return 'A001';
        }

        // Split the last code into its letter and number parts
        $letter = substr($lastCode, 0, 1); // Get the letter part
        $number = (int)substr($lastCode, 1); // Get the numeric part

        // Increment the number
        $number += 1;

        // If number exceeds 999, reset it to 001 and move to the next letter
        if ($number > 999) {
            $number = 1;
            $letter = chr(ord($letter) + 1); // Move to the next letter
        }

        // Combine the new letter and number, ensuring the number is padded to 3 digits
        return $letter . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

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
    $validate = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'phone' => 'required|unique:users',
        'role' => 'nullable|in:admin,user,driver',
        'image' => 'nullable|string',
    ]);

    if ($validate->fails()) {
        return response()->json($validate->errors(), 400);
    }

    $newcode=$this->generateNextCode();

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'image' => $imagePath ?? 'default.png',
        'role' => $request->role ?? 'user',
        'code'=>$newcode
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'message' => 'registered successfully',
        'data' => $user,
        'token' => $token,
    ]);
}


    public function login(Request $request){
        // dd($request);
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        $user = Driver::where('email', $request->email)
        ->first();
        if (empty($user)) {
            $user = User::where('email', $request->email)
            ->first();
        }
        if(empty($user)){
            return response()->json(['message'=>'invalid credentials'],401);
        }
        if (password_verify($request->input('password'), $user->password)) {

            if(is_null($user->user_code)){
                $newcode=$this->generateNextCode();
                $user->user_code=$newcode;
                $user->save();
            }
            $role=$user->role;
            $token=$user->createToken('auth_token')->plainTextToken;
            $adminposition=$user->admin_position;

            $data=[
                'message'=>'logged in successfully',
                'data'=>$user,
                'token'=>$token,
                'role'=>$role,
                'adminposition'=>$adminposition ?[
                    'id'=>$adminposition->id,
                    'name'=>$adminposition->name,
                    'role'=>$adminposition->role
                ]:null,
                'permissions'=>$adminposition?[
                    'role'=>$adminposition->role->pluck('role_name')
                ]:null
            ];
            return response()->json($data);
        } else {
            return response()->json(['message'=>'invalid credentials'],401);
        }

    }


    public function logout(Request $request){
        $user=$request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=>'logged out successfully']);
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
