<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPosition;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminrolesController extends Controller
{

    protected $updateadmin=['name','email','phone','image','password'];
    public function addadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required',
            'role' => 'nullable|in:admin',
            'image'=>'nullable|string',
            'admin_position_id'=>'nullable|exists:admin_positions,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $validator= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'image' => $request->image,
            'role' => $request->role ?? 'admin',
            'admin_position_id' => $request->admin_position_id ?? null,
        ]);

        return response()->json(['admin added successfully'=>$validator]);
    }



    public function addAdminPosition(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|unique:admin_positions,name',
            'role_name' => 'required|array',
            'role_name.*' => 'exists:roles,role_name',
        ]);

        // Create the admin position
        $adminposition = AdminPosition::create([
            'name' => $validated['name'],
        ]);

        // Assign all roles to the newly created admin position
        foreach ($validated['role_name'] as $role_name) {
            Role::create([
                'role_name' => $role_name,
                'admin_position_id' => $adminposition->id,
            ]);
        }

        // Now return the response after all roles have been assigned
        return response()->json([
            'message' => 'Admin position and roles added successfully',
            'data' => $adminposition->load('role'),
        ]);
    }

    public function showadminposition(Request $request){
        $roles = ['parkings','locations','offers','drivers','subscriptions','requests','plans','users','revenues','expences'];
        $admin_positions=AdminPosition::with('role')->get();
        $admins=User::where('role','admin')->get();
        $data=[
            'admin_positions'=>$admin_positions,
            'roles'=>$roles,
            'admins'=>$admins
        ];

        return response()->json($data);

    }

    public function addposistion(Request $request){
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|unique:admin_positions,name',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        AdminPosition::create([
            'name' => $request->name,
        ]);
        return response()->json(['message'=>'position added successfully']);
    }


}

